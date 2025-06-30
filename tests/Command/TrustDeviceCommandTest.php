<?php

namespace WechatWorkSecurityBundle\Tests\Command;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use WechatWorkBundle\Entity\Agent;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkSecurityBundle\Command\TrustDeviceCommand;
use WechatWorkSecurityBundle\Entity\TrustDevice;
use WechatWorkSecurityBundle\Enum\TrustDeviceSourceEnum;
use WechatWorkSecurityBundle\Enum\TrustDeviceStatusEnum;
use WechatWorkSecurityBundle\Request\TrustDeviceRequest;

class TrustDeviceCommandTest extends TestCase
{
    private AgentRepository $agentRepository;
    private WorkService $workService;
    private EntityManagerInterface $entityManager;
    private TrustDeviceCommand $command;

    protected function setUp(): void
    {
        $this->agentRepository = $this->createMock(AgentRepository::class);
        $this->workService = $this->createMock(WorkService::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        
        $this->command = new TrustDeviceCommand(
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

    public function testExecute_WithSingleAgent(): void
    {
        $agent = $this->createMock(Agent::class);
        $this->agentRepository->method('findAll')->willReturn([$agent]);
        
        $this->workService->method('request')
            ->willReturn([
                'errcode' => 0,
                'device_list' => [
                    [
                        'device_code' => 'DEV001',
                        'system' => 'Windows 10',
                        'seq_no' => 'SEQ001',
                        'mac_addr' => ['00:11:22:33:44:55'],
                        'source' => 1,
                        'status' => 1,
                        'motherboard_uuid' => 'MB-UUID-001',
                        'harddisk_uuid' => ['HD-UUID-001'],
                        'domain' => 'example.com',
                        'pc_name' => 'PC001',
                        'last_login_time' => time(),
                        'last_login_userid' => 'user123',
                        'confirm_timestamp' => time() - 3600,
                        'confirm_userid' => 'admin',
                        'approved_userid' => 'manager'
                    ]
                ]
            ]);
        
        // 3种类型，每种类型1个设备，共3次persist和flush
        $this->entityManager->expects($this->exactly(3))->method('persist');
        $this->entityManager->expects($this->exactly(3))->method('flush');
        
        $application = new Application();
        $application->add($this->command);
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['command' => $this->command->getName()]);
        
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }

    public function testExecute_WithMultipleAgentsAndDevices(): void
    {
        $agent1 = $this->createMock(Agent::class);
        $agent2 = $this->createMock(Agent::class);
        $this->agentRepository->method('findAll')->willReturn([$agent1, $agent2]);
        
        $this->workService->method('request')
            ->willReturn([
                'errcode' => 0,
                'device_list' => [
                    [
                        'device_code' => 'DEV001',
                        'system' => 'Windows 10',
                        'seq_no' => 'SEQ001',
                        'mac_addr' => ['00:11:22:33:44:55'],
                        'source' => 1,
                        'status' => 1,
                        'motherboard_uuid' => 'MB-UUID-001',
                        'harddisk_uuid' => ['HD-UUID-001'],
                        'domain' => 'example.com',
                        'pc_name' => 'PC001',
                        'last_login_time' => time(),
                        'last_login_userid' => 'user123',
                        'confirm_timestamp' => time() - 3600,
                        'confirm_userid' => 'admin',
                        'approved_userid' => 'manager'
                    ],
                    [
                        'device_code' => 'DEV002',
                        'system' => 'macOS',
                        'seq_no' => 'SEQ002',
                        'mac_addr' => ['00:11:22:33:44:66'],
                        'source' => 2,
                        'status' => 2,
                        'motherboard_uuid' => 'MB-UUID-002',
                        'harddisk_uuid' => ['HD-UUID-002'],
                        'domain' => 'example.com',
                        'pc_name' => 'MAC001',
                        'last_login_time' => time() - 7200,
                        'last_login_userid' => 'user456',
                        'confirm_timestamp' => time() - 10800,
                        'confirm_userid' => 'admin2',
                        'approved_userid' => 'manager2'
                    ]
                ]
            ]);
        
        // 2个agent * 3种类型 * 2个设备 = 12次persist和flush
        $this->entityManager->expects($this->exactly(12))->method('persist');
        $this->entityManager->expects($this->exactly(12))->method('flush');
        
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

    public function testExecute_WithEmptyDeviceList(): void
    {
        $agent = $this->createMock(Agent::class);
        $this->agentRepository->method('findAll')->willReturn([$agent]);
        
        $this->workService->method('request')
            ->willReturn(['errcode' => 0, 'device_list' => []]);
        
        $this->entityManager->expects($this->never())->method('persist');
        
        $application = new Application();
        $application->add($this->command);
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['command' => $this->command->getName()]);
        
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
    }

    public function testExecute_WithAllThreeDeviceTypes(): void
    {
        $agent = $this->createMock(Agent::class);
        $this->agentRepository->method('findAll')->willReturn([$agent]);
        
        $deviceData = [
            'device_code' => 'DEV-TYPE',
            'system' => 'Linux',
            'seq_no' => 'SEQ-TYPE',
            'mac_addr' => ['00:11:22:33:44:77'],
            'source' => 3,
            'status' => 3,
            'motherboard_uuid' => 'MB-UUID-TYPE',
            'harddisk_uuid' => ['HD-UUID-TYPE'],
            'domain' => 'test.com',
            'pc_name' => 'TEST-PC',
            'last_login_time' => time(),
            'last_login_userid' => 'testuser',
            'confirm_timestamp' => time() - 1800,
            'confirm_userid' => 'testadmin',
            'approved_userid' => 'testmanager'
        ];
        
        // 每种类型返回1个设备
        $this->workService->method('request')
            ->willReturn([
                'errcode' => 0,
                'device_list' => [$deviceData]
            ]);
        
        // 验证是否请求了3种类型（1,2,3）
        $requestedTypes = [];
        $this->workService->expects($this->exactly(3))
            ->method('request')
            ->willReturnCallback(function ($request) use (&$requestedTypes) {
                if ($request instanceof TrustDeviceRequest) {
                    $reflection = new \ReflectionObject($request);
                    $property = $reflection->getProperty('type');
                    $property->setAccessible(true);
                    $requestedTypes[] = $property->getValue($request);
                }
                return ['errcode' => 0, 'device_list' => []];
            });
        
        $application = new Application();
        $application->add($this->command);
        
        $commandTester = new CommandTester($this->command);
        $commandTester->execute(['command' => $this->command->getName()]);
        
        $this->assertEquals(Command::SUCCESS, $commandTester->getStatusCode());
        $this->assertEquals([1, 2, 3], $requestedTypes);
    }
}