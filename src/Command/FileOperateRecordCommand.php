<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Command;

use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WechatWorkBundle\Entity\Agent;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkSecurityBundle\Entity\FileOperateRecord;
use WechatWorkSecurityBundle\Enum\FileOperateDeviceCodeEnum;
use WechatWorkSecurityBundle\Request\FileOperateRecordRequest;

/**
 * @see https://developer.work.weixin.qq.com/document/path/98079
 */
// #[AsCronTask(expression: '* * * * *')]
#[AsCommand(name: self::NAME, description: '文件防泄漏')]
class FileOperateRecordCommand extends Command
{
    public const NAME = 'wechat-work:file-operate-record';

    public function __construct(
        private readonly AgentRepository $agentRepository,
        private readonly WorkService $workService,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('文件防泄漏')
            ->addArgument('startTime', InputArgument::OPTIONAL, 'order start time', CarbonImmutable::now()->subDay()->startOfDay()->format('Y-m-d H:i:s'))
            ->addArgument('endTime', InputArgument::OPTIONAL, 'order end time', CarbonImmutable::now()->subDay()->endOfDay()->format('Y-m-d H:i:s'))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $startTimeString = $input->getArgument('startTime');
        $endTimeString = $input->getArgument('endTime');

        // 确保参数为字符串类型以满足CarbonImmutable::parse()的类型要求
        assert(is_string($startTimeString) || is_null($startTimeString));
        assert(is_string($endTimeString) || is_null($endTimeString));

        $startTime = CarbonImmutable::parse($startTimeString ?? '');
        $endTime = CarbonImmutable::parse($endTimeString ?? '');

        $validationResult = $this->validateTimeRange($startTime, $endTime, $output);
        if (Command::SUCCESS !== $validationResult) {
            return $validationResult;
        }

        $this->processAgents($startTime, $endTime);

        return Command::SUCCESS;
    }

    private function validateTimeRange(CarbonImmutable $startTime, CarbonImmutable $endTime, OutputInterface $output): int
    {
        if ($endTime <= $startTime) {
            $output->writeln('结束时间必须大于开始时间');

            return Command::FAILURE;
        }

        $daysDifference = $startTime->diffInDays($endTime);
        if ($daysDifference > 14) {
            $output->writeln('开始时间到结束时间的范围不能超过14天');

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function processAgents(CarbonImmutable $startTime, CarbonImmutable $endTime): void
    {
        /** @var list<Agent> $agents */
        $agents = $this->agentRepository->findAll();
        foreach ($agents as $agent) {
            $request = new FileOperateRecordRequest();
            $request->setAgent($agent);
            $timestamp = $startTime->timestamp;
            $request->setStartTime((string) $timestamp);
            $timestamp = (int) $endTime->timestamp;
            $request->setEndTime($timestamp);
            $result = $this->workService->request($request);

            // 确保WorkService返回的是数组类型，安全访问数组偏移
            assert(is_array($result));
            if (isset($result['errcode']) && 0 === $result['errcode']) {
                if (isset($result['record_list']) && is_array($result['record_list'])) {
                    $this->processRecords($result['record_list']);
                }
            }
        }
    }

    /**
     * @param array<mixed> $records
     */
    private function processRecords(array $records): void
    {
        foreach ($records as $record) {
            // 确保每条记录是数组类型
            if (!is_array($record)) {
                continue; // 跳过无效记录
            }
            $fileOperateRecord = $this->createFileOperateRecord($record);
            $this->entityManager->persist($fileOperateRecord);
            $this->entityManager->flush();
        }
    }

    /**
     * 安全设置字符串字段的通用方法
     *
     * @param array<mixed> $record
     */
    private function setStringField(FileOperateRecord $fileOperateRecord, array $record, string $fieldName, callable $setter): void
    {
        if (!isset($record[$fieldName])) {
            return;
        }

        $value = $record[$fieldName];
        if (is_string($value)) {
            $setter($value);
        } elseif (is_scalar($value)) {
            $setter((string) $value);
        }
    }

    /**
     * 安全设置时间字段
     *
     * @param array<mixed> $record
     */
    private function setTimeField(FileOperateRecord $fileOperateRecord, array $record): void
    {
        if (!isset($record['time'])) {
            return;
        }

        $time = is_numeric($record['time']) ? (int) $record['time'] : 0;
        $fileOperateRecord->setTime(CarbonImmutable::createFromTimestamp($time, date_default_timezone_get()));
    }

    /**
     * 安全设置设备类型字段（枚举处理）
     *
     * @param array<mixed> $record
     */
    private function setDeviceTypeField(FileOperateRecord $fileOperateRecord, array $record): void
    {
        if (!isset($record['device_type'])) {
            return;
        }

        $deviceTypeValue = null;
        if (is_string($record['device_type'])) {
            $deviceTypeValue = $record['device_type'];
        } elseif (is_numeric($record['device_type'])) {
            $deviceTypeValue = (int) $record['device_type'];
        }

        if (null !== $deviceTypeValue) {
            $deviceType = FileOperateDeviceCodeEnum::tryFrom($deviceTypeValue);
            if (null !== $deviceType) {
                $fileOperateRecord->setDeviceType($deviceType);
            }
        }
    }

    /**
     * @param array<mixed> $record
     */
    private function createFileOperateRecord(array $record): FileOperateRecord
    {
        $fileOperateRecord = new FileOperateRecord();

        // 处理时间字段
        $this->setTimeField($fileOperateRecord, $record);

        // 处理字符串字段
        $this->setStringField($fileOperateRecord, $record, 'user_id', fn($v) => $fileOperateRecord->setUserid($v));
        $this->setStringField($fileOperateRecord, $record, 'operation', fn($v) => $fileOperateRecord->setOperation($v));
        $this->setStringField($fileOperateRecord, $record, 'file_info', fn($v) => $fileOperateRecord->setFileInfo($v));

        $this->setOptionalFields($fileOperateRecord, $record);

        return $fileOperateRecord;
    }

    /**
     * @param array<mixed> $record
     */
    private function setOptionalFields(FileOperateRecord $fileOperateRecord, array $record): void
    {
        // 处理可选的字符串字段
        $this->setStringField($fileOperateRecord, $record, 'file_size', fn($v) => $fileOperateRecord->setFileSize($v));
        $this->setStringField($fileOperateRecord, $record, 'file_md5', fn($v) => $fileOperateRecord->setFileMd5($v));
        $this->setStringField($fileOperateRecord, $record, 'applicant_name', fn($v) => $fileOperateRecord->setApplicantName($v));
        $this->setStringField($fileOperateRecord, $record, 'device_code', fn($v) => $fileOperateRecord->setDeviceCode($v));

        // 处理设备类型（枚举字段）
        $this->setDeviceTypeField($fileOperateRecord, $record);
    }
}
