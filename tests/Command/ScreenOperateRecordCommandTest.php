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
use WechatWorkSecurityBundle\Command\ScreenOperateRecordCommand;
use WechatWorkSecurityBundle\Entity\ScreenOperateRecord;
use WechatWorkSecurityBundle\Enum\ScreenShotTypeEnum;
use WechatWorkSecurityBundle\Request\ScreenOperateRecordRequest;

class ScreenOperateRecordCommandTest extends TestCase
{
    private AgentRepository $agentRepository;
    private WorkService $workService;
    private EntityManagerInterface $entityManager;
    private ScreenOperateRecordCommand $command;

    protected function setUp(): void
    {
        $this->agentRepository = $this->createMock(AgentRepository::class);
        $this->workService = $this->createMock(WorkService::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        
        $this->command = new ScreenOperateRecordCommand(
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
                        'system' => 'Windows',
                        'time' => time(),
                        'userid' => 'user123',
                        'screen_shot_content' => 'content1',
                        'screen_shot_type' => 1,
                        'department_id' => 123
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

    public function testExecute_WithCustomTimeRange(): void
    {
        $agent = $this->createMock(Agent::class);
        $this->agentRepository->method('findAll')->willReturn([$agent]);
        
        $this->workService->method('request')
            ->willReturn(['errcode' => 0, 'record_list' => []]);
        
        $application = new Application();
        $application->add($this->command);
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute([
            'command' => $this->command->getName(),
            'startTime' => '2025-01-01 00:00:00',
            'endTime' => '2025-01-07 23:59:59'
        ]);
        
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }

    public function testExecute_WithTimeRangeExceeding14Days(): void
    {
        $application = new Application();
        $application->add($this->command);
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute([
            'command' => $this->command->getName(),
            'startTime' => '2025-01-01 00:00:00',
            'endTime' => '2025-01-16 23:59:59'
        ]);
        
        $this->assertEquals(Command::FAILURE, $commandTester->getStatusCode());
        $this->assertStringContainsString('开始时间到结束时间的范围不能超过14天', $commandTester->getDisplay());
    }

    public function testExecute_WithMultipleAgents(): void
    {
        $agent1 = $this->createMock(Agent::class);
        $agent2 = $this->createMock(Agent::class);
        $this->agentRepository->method('findAll')->willReturn([$agent1, $agent2]);
        
        $this->workService->method('request')
            ->willReturn([
                'errcode' => 0,
                'record_list' => [
                    [
                        'system' => 'macOS',
                        'time' => time(),
                        'userid' => 'user456',
                        'screen_shot_content' => 'content2',
                        'screen_shot_type' => 2,
                        'department_id' => 456
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
                        'system' => 'Windows',
                        'time' => time(),
                        'userid' => 'user1',
                        'screen_shot_content' => 'content1',
                        'screen_shot_type' => 1,
                        'department_id' => 1
                    ],
                    [
                        'system' => 'Linux',
                        'time' => time() - 3600,
                        'userid' => 'user2',
                        'screen_shot_content' => 'content2',
                        'screen_shot_type' => 2,
                        'department_id' => 2
                    ],
                    [
                        'system' => 'macOS',
                        'time' => time() - 7200,
                        'userid' => 'user3',
                        'screen_shot_content' => 'content3',
                        'screen_shot_type' => 3,
                        'department_id' => 3
                    ]
                ]
            ]);
        
        $this->entityManager->expects($this->exactly(3))->method('persist');
        $this->entityManager->expects($this->exactly(3))->method('flush');
        
        $application = new Application();
        $application->add($this->command);
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['command' => $this->command->getName()]);
        
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }
}