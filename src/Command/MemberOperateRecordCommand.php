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
use WechatWorkSecurityBundle\Entity\MemberOperateRecord;
use WechatWorkSecurityBundle\Request\MemberOperateRecordRequest;

/**
 * @see https://developer.work.weixin.qq.com/document/path/100178
 */
// #[AsCronTask(expression: '* * * * *')]
#[AsCommand(name: self::NAME, description: '获取成员操作记录')]
final class MemberOperateRecordCommand extends Command
{
    public const NAME = 'wechat-work:member-operate-record';

    public function __construct(
        private readonly AgentRepository $agentRepository,
        private readonly WorkService $workService,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('获取成员操作记录')
            ->addArgument('startTime', InputArgument::OPTIONAL, 'order start time', CarbonImmutable::now()->subDay()->startOfDay()->format('Y-m-d H:i:s'))
            ->addArgument('endTime', InputArgument::OPTIONAL, 'order end time', CarbonImmutable::now()->subDay()->endOfDay()->format('Y-m-d H:i:s'))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $startTimeString = $input->getArgument('startTime');
        $endTimeString = $input->getArgument('endTime');

        // 确保时间参数为字符串类型
        assert(is_string($startTimeString) || is_null($startTimeString));
        assert(is_string($endTimeString) || is_null($endTimeString));

        $startTime = CarbonImmutable::parse($startTimeString);
        $endTime = CarbonImmutable::parse($endTimeString);

        $validationResult = $this->validateTimeRange($startTime, $endTime, $output);
        if (Command::SUCCESS !== $validationResult) {
            return $validationResult;
        }

        $this->processAgents($startTime, $endTime);

        return Command::SUCCESS;
    }

    private function validateTimeRange(CarbonImmutable $startTime, CarbonImmutable $endTime, OutputInterface $output): int
    {
        $currentTime = CarbonImmutable::now();
        $minStartTime = CarbonImmutable::now()->subDays(180);

        if ($startTime < $minStartTime) {
            $output->writeln('开始时间不能早于当前时间的 180 天前');

            return Command::FAILURE;
        }

        if ($endTime <= $startTime) {
            $output->writeln('结束时间必须大于开始时间');

            return Command::FAILURE;
        }

        if ($endTime >= $currentTime) {
            $output->writeln('结束时间必须小于当前时间');

            return Command::FAILURE;
        }

        $daysDifference = $startTime->diffInDays($endTime);
        if ($daysDifference > 7) {
            $output->writeln('开始时间和结束时间之间的跨度不能超过 7 天');

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }

    private function processAgents(CarbonImmutable $startTime, CarbonImmutable $endTime): void
    {
        /** @var list<Agent> $agents */
        $agents = $this->agentRepository->findAll();
        foreach ($agents as $agent) {
            $request = new MemberOperateRecordRequest();
            $request->setAgent($agent);
            $request->setStartTime((int) $startTime->timestamp);
            $request->setEndTime((int) $endTime->timestamp);
            $result = $this->workService->request($request);

            // 类型守卫：确保 $result 是数组格式
            if (is_array($result) && isset($result['errcode']) && 0 === $result['errcode']) {
                // 确保 record_list 存在且为数组
                $recordList = $result['record_list'] ?? [];
                assert(is_array($recordList));

                $this->processRecords($recordList);
            }
        }
    }

    /**
     * @param array<mixed> $records
     */
    private function processRecords(array $records): void
    {
        foreach ($records as $record) {
            // 类型守卫：确保 $record 是数组格式
            if (!is_array($record)) {
                continue;
            }

            $memberOperateRecord = $this->createMemberOperateRecord($record);
            $this->entityManager->persist($memberOperateRecord);
            $this->entityManager->flush();
        }
    }

    /**
     * @param array<mixed> $record
     */
    private function createMemberOperateRecord(array $record): MemberOperateRecord
    {
        $memberOperateRecord = new MemberOperateRecord();

        // 类型守卫：确保所有字段都是预期的类型
        $operType = $record['oper_type'] ?? null;
        assert(is_string($operType) || is_null($operType));
        $memberOperateRecord->setOperType($operType);

        $time = $record['time'] ?? 0;
        assert(is_numeric($time));
        $memberOperateRecord->setTime(CarbonImmutable::createFromTimestamp((int) $time, date_default_timezone_get()));

        $detailInfo = $record['detail_info'] ?? null;
        assert(is_string($detailInfo) || is_null($detailInfo));
        $memberOperateRecord->setDetailInfo($detailInfo);

        $ip = $record['ip'] ?? null;
        assert(is_string($ip) || is_null($ip));
        $memberOperateRecord->setIp($ip);

        $userid = $record['userid'] ?? null;
        assert(is_string($userid) || is_null($userid));
        $memberOperateRecord->setUserid($userid);

        return $memberOperateRecord;
    }
}
