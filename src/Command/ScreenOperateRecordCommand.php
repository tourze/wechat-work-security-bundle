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
use WechatWorkSecurityBundle\Entity\ScreenOperateRecord;
use WechatWorkSecurityBundle\Enum\ScreenShotTypeEnum;
use WechatWorkSecurityBundle\Request\ScreenOperateRecordRequest;

/**
 * @see https://developer.work.weixin.qq.com/document/path/100128
 */
// #[AsCronTask(expression: '* * * * *')]
#[AsCommand(name: self::NAME, description: '截屏/录屏管理')]
class ScreenOperateRecordCommand extends Command
{
    public const NAME = 'wechat-work:screen-operate-record';

    public function __construct(
        private readonly AgentRepository $agentRepository,
        private readonly WorkService $workService,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('截屏/录屏管理')
            ->addArgument('startTime', InputArgument::OPTIONAL, 'order start time', CarbonImmutable::now()->subDay()->startOfDay()->format('Y-m-d H:i:s'))
            ->addArgument('endTime', InputArgument::OPTIONAL, 'order end time', CarbonImmutable::now()->subDay()->endOfDay()->format('Y-m-d H:i:s'))
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $startTimeString = $input->getArgument('startTime');
        $endTimeString = $input->getArgument('endTime');

        // 类型守卫：确保参数为字符串类型
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
            $request = new ScreenOperateRecordRequest();
            $request->setAgent($agent);
            $request->setStartTime((int) $startTime->timestamp);
            $request->setEndTime((int) $endTime->timestamp);
            $result = $this->workService->request($request);

            // 类型守卫：确保API返回的是数组格式
            assert(is_array($result));

            if (isset($result['errcode']) && 0 === $result['errcode']) {
                // 类型守卫：确保record_list是数组
                assert(isset($result['record_list']) && is_array($result['record_list']));
                $this->processRecords($result['record_list']);
            }
        }
    }

    /**
     * @param array<mixed> $records
     */
    private function processRecords(array $records): void
    {
        foreach ($records as $record) {
            // 类型守卫：确保每条记录都是数组格式
            assert(is_array($record));

            $screenOperateRecord = $this->createScreenOperateRecord($record);
            $this->entityManager->persist($screenOperateRecord);
            $this->entityManager->flush();
        }
    }

    /**
     * @param array<mixed> $record
     */
    private function createScreenOperateRecord(array $record): ScreenOperateRecord
    {
        // 类型守卫：确保必需字段存在且类型正确
        assert(isset($record['system']));
        assert(isset($record['time']));
        assert(isset($record['userid']));
        assert(isset($record['screen_shot_content']));
        assert(isset($record['screen_shot_type']));
        assert(isset($record['department_id']));

        // 确保字段类型符合预期
        assert(is_null($record['system']) || is_string($record['system']));
        assert(is_numeric($record['time'])); // 时间戳应该是数字
        assert(is_null($record['userid']) || is_string($record['userid']));
        assert(is_null($record['screen_shot_content']) || is_string($record['screen_shot_content']));
        assert(is_numeric($record['screen_shot_type'])); // 枚举值应该是数字
        assert(is_null($record['department_id']) || is_numeric($record['department_id']));

        $screenOperateRecord = new ScreenOperateRecord();
        $screenOperateRecord->setSystem($record['system']);
        $screenOperateRecord->setTime(CarbonImmutable::createFromTimestamp((int) $record['time'], date_default_timezone_get()));
        $screenOperateRecord->setUserid($record['userid']);
        $screenOperateRecord->setScreenShotContent($record['screen_shot_content']);

        $screenShotType = ScreenShotTypeEnum::tryFrom((int) $record['screen_shot_type']);
        $screenOperateRecord->setScreenShotType($screenShotType);
        $departmentId = is_null($record['department_id']) ? null : (int) $record['department_id'];
        $screenOperateRecord->setDepartmentId($departmentId);

        return $screenOperateRecord;
    }
}
