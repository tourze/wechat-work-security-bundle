<?php

namespace WechatWorkSecurityBundle\Tests\Command;

use Carbon\CarbonImmutable;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use WechatWorkBundle\Entity\Agent;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkSecurityBundle\Command\MemberOperateRecordCommand;
use WechatWorkSecurityBundle\Entity\MemberOperateRecord;
use WechatWorkSecurityBundle\Request\MemberOperateRecordRequest;

class MemberOperateRecordCommandTest extends TestCase
{
    private AgentRepository $agentRepository;
    private WorkService $workService;
    private EntityManagerInterface $entityManager;
    private MemberOperateRecordCommand $command;

    protected function setUp(): void
    {
        $this->agentRepository = $this->createMock(AgentRepository::class);
        $this->workService = $this->createMock(WorkService::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        
        $this->command = new MemberOperateRecordCommand(
            $this->agentRepository,
            $this->workService,
            $this->entityManager
        );
    }

    public function testExecute_WithNoAgents(): void
    {
        $this->agentRepository->method('findAll')->willReturn([]);
        
        $application = new Application();
        $application->add($this->command);
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['command' => $this->command->getName()]);
        
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }

    public function testExecute_WithDefaultTimeRange(): void
    {
        $agent = $this->createMock(Agent::class);
        $this->agentRepository->method('findAll')->willReturn([$agent]);
        
        $this->workService->method('request')
            ->willReturn([
                'errcode' => 0,
                'record_list' => [
                    [
                        'oper_type' => 1,
                        'time' => time(),
                        'detail_info' => 'Detail info',
                        'ip' => '192.168.1.1',
                        'userid' => 'user123'
                    ]
                ]
            ]);
        
        $this->entityManager->expects($this->once())->method('persist');
        $this->entityManager->expects($this->once())->method('flush');
        
        $application = new Application();
        $application->add($this->command);
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['command' => $this->command->getName()]);
        
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }

    public function testExecute_WithStartTimeTooEarly(): void
    {
        $application = new Application();
        $application->add($this->command);
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute([
            'command' => $this->command->getName(),
            'startTime' => '2024-01-01 00:00:00',
            'endTime' => '2024-01-07 23:59:59'
        ]);
        
        $this->assertEquals(Command::FAILURE, $commandTester->getStatusCode());
        $this->assertStringContainsString('开始时间不能早于当前时间的 180 天前', $commandTester->getDisplay());
    }

    public function testExecute_WithEndTimeBeforeStartTime(): void
    {
        $application = new Application();
        $application->add($this->command);
        
        $startTime = CarbonImmutable::now()->subDays(30);
        $endTime = CarbonImmutable::now()->subDays(31);
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute([
            'command' => $this->command->getName(),
            'startTime' => $startTime->format('Y-m-d H:i:s'),
            'endTime' => $endTime->format('Y-m-d H:i:s')
        ]);
        
        $this->assertEquals(Command::FAILURE, $commandTester->getStatusCode());
        $this->assertStringContainsString('结束时间必须大于开始时间', $commandTester->getDisplay());
    }

    public function testExecute_WithEndTimeInFuture(): void
    {
        $application = new Application();
        $application->add($this->command);
        
        $startTime = CarbonImmutable::now()->subDays(2);
        $endTime = CarbonImmutable::now()->addDay();
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute([
            'command' => $this->command->getName(),
            'startTime' => $startTime->format('Y-m-d H:i:s'),
            'endTime' => $endTime->format('Y-m-d H:i:s')
        ]);
        
        $this->assertEquals(Command::FAILURE, $commandTester->getStatusCode());
        $this->assertStringContainsString('结束时间必须小于当前时间', $commandTester->getDisplay());
    }

    public function testExecute_WithTimeRangeExceeding7Days(): void
    {
        $application = new Application();
        $application->add($this->command);
        
        $startTime = CarbonImmutable::now()->subDays(10);
        $endTime = CarbonImmutable::now()->subDays(2);
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute([
            'command' => $this->command->getName(),
            'startTime' => $startTime->format('Y-m-d H:i:s'),
            'endTime' => $endTime->format('Y-m-d H:i:s')
        ]);
        
        $this->assertEquals(Command::FAILURE, $commandTester->getStatusCode());
        $this->assertStringContainsString('开始时间和结束时间之间的跨度不能超过 7 天', $commandTester->getDisplay());
    }

    public function testExecute_WithApiError(): void
    {
        $agent = $this->createMock(Agent::class);
        $this->agentRepository->method('findAll')->willReturn([$agent]);
        
        $this->workService->method('request')
            ->willReturn(['errcode' => 1, 'errmsg' => 'API error']);
        
        $this->entityManager->expects($this->never())->method('persist');
        
        $application = new Application();
        $application->add($this->command);
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['command' => $this->command->getName()]);
        
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }

    public function testExecute_WithMultipleRecords(): void
    {
        $agent = $this->createMock(Agent::class);
        $this->agentRepository->method('findAll')->willReturn([$agent]);
        
        $this->workService->method('request')
            ->willReturn([
                'errcode' => 0,
                'record_list' => [
                    [
                        'oper_type' => 1,
                        'time' => time(),
                        'detail_info' => 'Detail 1',
                        'ip' => '192.168.1.1',
                        'userid' => 'user1'
                    ],
                    [
                        'oper_type' => 2,
                        'time' => time() - 3600,
                        'detail_info' => 'Detail 2',
                        'ip' => '192.168.1.2',
                        'userid' => 'user2'
                    ]
                ]
            ]);
        
        $this->entityManager->expects($this->exactly(2))->method('persist');
        $this->entityManager->expects($this->exactly(2))->method('flush');
        
        $application = new Application();
        $application->add($this->command);
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['command' => $this->command->getName()]);
        
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }
}