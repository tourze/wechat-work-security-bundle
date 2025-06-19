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
use WechatWorkSecurityBundle\Entity\MemberOperateRecord;
use WechatWorkSecurityBundle\Request\MemberOperateRecordRequest;

/**
 * @see https://developer.work.weixin.qq.com/document/path/100178
 */
// #[AsCronTask('* * * * *')]
#[AsCommand(name: 'wechat-work:member-operate-record', description: '获取成员操作记录')]
class MemberOperateRecordCommand extends Command
{
    public const NAME = 'member-operate-record';

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
        // 获取当前时间
        $currentTime = Carbon::now();
        $minStartTime = Carbon::now()->subDays(180);
        if ($startTime < $minStartTime) {
            $output->writeln('开始时间不能早于当前时间的 180 天前');

            return Command::FAILURE;
        }

        // 检查结束时间
        if ($endTime <= $startTime) {
            $output->writeln('结束时间必须大于开始时间');

            return Command::FAILURE;
        }

        if ($endTime >= $currentTime) {
            $output->writeln('结束时间必须小于当前时间');

            return Command::FAILURE;
        }

        // 检查开始时间和结束时间之间的跨度是否超过 7 天
        $daysDifference = $endTime->diffInDays($startTime);
        if ($daysDifference > 7) {
            $output->writeln('开始时间和结束时间之间的跨度不能超过 7 天');

            return Command::FAILURE;
        }
        foreach ($this->agentRepository->findAll() as $agent) {
            $request = new MemberOperateRecordRequest();
            $request->setAgent($agent);
            $request->setStartTime(strtotime($startTime));
            $request->setEndTime(strtotime($endTime));
            $result = $this->workService->request($request);
            if (isset($result['errcode']) && 0 == $result['errcode']) {
                foreach ($result['record_list'] as $record) {
                    $memberOperateRecord = new MemberOperateRecord();
                    $memberOperateRecord->setOperType($record['oper_type']);
                    $memberOperateRecord->setTime(Carbon::createFromTimestamp($record['time'], date_default_timezone_get()));
                    $memberOperateRecord->setDetailInfo($record['detail_info']);
                    $memberOperateRecord->setIp($record['ip']);
                    $memberOperateRecord->setUserid($record['userid']);
                    $this->entityManager->persist($memberOperateRecord);
                    $this->entityManager->flush();
                }
            }
        }

        return Command::SUCCESS;
    }
}
