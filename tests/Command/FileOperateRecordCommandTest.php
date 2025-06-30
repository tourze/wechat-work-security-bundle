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
use WechatWorkSecurityBundle\Command\FileOperateRecordCommand;
use WechatWorkSecurityBundle\Entity\FileOperateRecord;
use WechatWorkSecurityBundle\Enum\FileOperateDeviceCodeEnum;
use WechatWorkSecurityBundle\Request\FileOperateRecordRequest;

class FileOperateRecordCommandTest extends TestCase
{
    private AgentRepository $agentRepository;
    private WorkService $workService;
    private EntityManagerInterface $entityManager;
    private FileOperateRecordCommand $command;

    protected function setUp(): void
    {
        $this->agentRepository = $this->createMock(AgentRepository::class);
        $this->workService = $this->createMock(WorkService::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        
        $this->command = new FileOperateRecordCommand(
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
                        'time' => time(),
                        'user_id' => 'user123',
                        'operation' => 'download',
                        'file_info' => 'test.pdf',
                        'file_size' => 1024,
                        'file_md5' => 'abc123',
                        'applicant_name' => 'Test User',
                        'device_type' => 1,
                        'device_code' => 'DEV001'
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

    public function testExecute_WithPartialRecordData(): void
    {
        $agent = $this->createMock(Agent::class);
        $this->agentRepository->method('findAll')->willReturn([$agent]);
        
        // 测试部分字段缺失的情况
        $this->workService->method('request')
            ->willReturn([
                'errcode' => 0,
                'record_list' => [
                    [
                        'time' => time(),
                        'user_id' => 'user123',
                        'operation' => 'download',
                        'file_info' => 'test.pdf'
                        // 缺少可选字段
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
}