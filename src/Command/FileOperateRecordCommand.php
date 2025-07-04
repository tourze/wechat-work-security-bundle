<?php

namespace WechatWorkSecurityBundle\Command;

use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
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
            ->addArgument('endTime', InputArgument::OPTIONAL, 'order end time', CarbonImmutable::now()->subDay()->endOfDay()->format('Y-m-d H:i:s'));
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $startTimeString = $input->getArgument('startTime');
        $endTimeString = $input->getArgument('endTime');

        $startTime = CarbonImmutable::parse($startTimeString);
        $endTime = CarbonImmutable::parse($endTimeString);
        
        // 确保结束时间在开始时间之后
        if ($endTime <= $startTime) {
            $output->writeln('结束时间必须大于开始时间');
            return Command::FAILURE;
        }
        
        $daysDifference = $startTime->diffInDays($endTime);

        // 判断时间范围是否超过 14 天
        if ($daysDifference > 14) {
            $output->writeln('开始时间到结束时间的范围不能超过14天');

            return Command::FAILURE;
        }

        foreach ($this->agentRepository->findAll() as $agent) {
            $request = new FileOperateRecordRequest();
            $request->setAgent($agent);
            $request->setStartTime((string)strtotime($startTime));
            $request->setEndTime(strtotime($endTime));
            $result = $this->workService->request($request);

            if (isset($result['errcode']) && 0 == $result['errcode']) {
                foreach ($result['record_list'] as $record) {
                    $fileOperateRecord = new FileOperateRecord();
                    $fileOperateRecord->setTime(CarbonImmutable::createFromTimestamp($record['time'], date_default_timezone_get()));
                    $fileOperateRecord->setUserid($record['user_id']);
                    $fileOperateRecord->setOperation($record['operation']);
                    $fileOperateRecord->setFileInfo($record['file_info']);
                    // 字段存在不返回的情况，多做个判断
                    if (isset($record['file_size'])) {
                        $fileOperateRecord->setFileSize($record['file_size']);
                    }
                    if (isset($record['file_md5'])) {
                        $fileOperateRecord->setFileMd5($record['file_md5']);
                    }
                    if (isset($record['applicant_name'])) {
                        $fileOperateRecord->setApplicantName($record['applicant_name']);
                    }
                    if (isset($record['device_type'])) {
                        $fileOperateRecord->setDeviceType(FileOperateDeviceCodeEnum::tryFrom($record['device_type']));
                    }
                    if (isset($record['device_code'])) {
                        $fileOperateRecord->setDeviceCode($record['device_code']);
                    }

                    $this->entityManager->persist($fileOperateRecord);
                    $this->entityManager->flush();
                }
            }
        }

        return Command::SUCCESS;
    }
}
