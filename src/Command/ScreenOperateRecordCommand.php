<?php

namespace WechatWorkSecurityBundle\Command;

use Carbon\Carbon;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkSecurityBundle\Entity\ScreenOperateRecord;
use WechatWorkSecurityBundle\Enum\ScreenShotTypeEnum;
use WechatWorkSecurityBundle\Request\ScreenOperateRecordRequest;

/**
 * @see https://developer.work.weixin.qq.com/document/path/100128
 */
// #[AsCronTask('* * * * *')]
#[AsCommand(name: 'wechat-work:screen-operate-record', description: '截屏/录屏管理')]
class ScreenOperateRecordCommand extends Command
{
    public const NAME = 'screen-operate-record';

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
            ->addArgument('startTime', InputArgument::OPTIONAL, 'order start time', Carbon::now()->subDay()->startOfDay()->format('Y-m-d H:i:s'))
            ->addArgument('endTime', InputArgument::OPTIONAL, 'order end time', Carbon::now()->subDay()->endOfDay()->format('Y-m-d H:i:s'));
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $startTimeString = $input->getArgument('startTime');
        $endTimeString = $input->getArgument('endTime');
        // 转换一下
        $startTime = Carbon::parse($startTimeString);
        $endTime = Carbon::parse($endTimeString);
        $daysDifference = $endTime->diffInDays($startTime);

        // 判断时间范围是否超过 14 天
        if ($daysDifference > 14) {
            $output->writeln('开始时间到结束时间的范围不能超过14天');

            return Command::FAILURE;
        }

        foreach ($this->agentRepository->findAll() as $agent) {
            $request = new ScreenOperateRecordRequest();
            $request->setAgent($agent);
            $request->setStartTime(strtotime($startTime));
            $request->setEndTime(strtotime($endTime));
            $result = $this->workService->request($request);
            if (isset($result['errcode']) && 0 == $result['errcode']) {
                foreach ($result['record_list'] as $record) {
                    $screenOperateRecord = new ScreenOperateRecord();
                    $screenOperateRecord->setSystem($record['system']);
                    $screenOperateRecord->setTime(Carbon::createFromTimestamp($record['time'], date_default_timezone_get()));
                    $screenOperateRecord->setUserid($record['userid']);
                    $screenOperateRecord->setScreenShotContent($record['screen_shot_content']);

                    $screenShotType = ScreenShotTypeEnum::tryFrom($record['screen_shot_type']);
                    $screenOperateRecord->setScreenShotType($screenShotType);
                    $screenOperateRecord->setDepartmentId($record['department_id']);
                    $this->entityManager->persist($screenOperateRecord);
                    $this->entityManager->flush();
                }
            }
        }

        return Command::SUCCESS;
    }
}
