<?php

namespace WechatWorkSecurityBundle\Tests\Command;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use WechatWorkBundle\Entity\Agent;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkSecurityBundle\Command\TrustDeviceCommand;
use WechatWorkSecurityBundle\Entity\TrustDevice;
use WechatWorkSecurityBundle\Enum\TrustDeviceSourceEnum;
use WechatWorkSecurityBundle\Enum\TrustDeviceStatusEnum;

class TrustDeviceCommandTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private AgentRepository $agentRepository;
    private WorkService $workService;
    private CommandTester $commandTester;

    protected function setUp(): void
    {
        // 创建模拟对象
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->agentRepository = $this->createMock(AgentRepository::class);
        $this->workService = $this->createMock(WorkService::class);

        // 创建命令
        $command = new TrustDeviceCommand(
            $this->agentRepository,
            $this->workService,
            $this->entityManager
        );

        // 创建应用程序并添加命令
        $application = new Application();
        $application->add($command);

        // 获取命令
        $command = $application->find('wechat-work:trust-device');

        // 创建命令测试器
        $this->commandTester = new CommandTester($command);
    }

    public function testExecute_withValidResponse_shouldPersistDevices(): void
    {
        // 创建测试Agent
        $agent = new Agent();

        // 配置AgentRepository返回测试Agent
        $this->agentRepository->expects($this->once())
            ->method('findAll')
            ->willReturn([$agent]);

        // 模拟API响应数据
        $apiResponse = [
            'errcode' => 0,
            'errmsg' => 'ok',
            'device_list' => [
                [
                    'device_code' => 'test-device-code',
                    'system' => 'Windows',
                    'seq_no' => 'test-seq-no',
                    'mac_addr' => ['test-mac-addr'],
                    'source' => TrustDeviceSourceEnum::ADMIN_IMPORT->value,
                    'status' => TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE->value,
                    'motherboard_uuid' => 'test-motherboard-uuid',
                    'harddisk_uuid' => ['test-harddisk-uuid'],
                    'domain' => 'test-domain',
                    'pc_name' => 'test-pc-name',
                    'last_login_time' => '1620000000',
                    'last_login_userid' => 'test-user-id',
                    'confirm_timestamp' => '1620000000',
                    'confirm_userid' => 'test-confirm-userid',
                    'approved_userid' => 'test-approved-userid',
                ],
            ],
        ];

        // 配置WorkService以返回模拟响应
        $this->workService->expects($this->exactly(3))
            ->method('request')
            ->willReturn($apiResponse);

        // 验证EntityManager被调用以持久化和刷新实体
        $this->entityManager->expects($this->exactly(3))
            ->method('persist')
            ->with($this->callback(function (TrustDevice $device) {
                // 验证设备属性
                return $device->getDeviceCode() === 'test-device-code'
                    && $device->getSystem() === 'Windows'
                    && $device->getSeqNo() === 'test-seq-no'
                    && $device->getMacAddr() === 'test-mac-addr'
                    && $device->getSource() === TrustDeviceSourceEnum::ADMIN_IMPORT
                    && $device->getStatus() === TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE
                    && $device->getMotherboardUuid() === 'test-motherboard-uuid'
                    && $device->getHarddiskUuid() === 'test-harddisk-uuid'
                    && $device->getDomain() === 'test-domain'
                    && $device->getPcName() === 'test-pc-name'
                    && $device->getLastLoginTime() === '1620000000'
                    && $device->getLastLoginUserid() === 'test-user-id'
                    && $device->getConfirmTimestamp() === '1620000000'
                    && $device->getConfirmUserid() === 'test-confirm-userid'
                    && $device->getApprovedUserid() === 'test-approved-userid';
            }));

        $this->entityManager->expects($this->exactly(3))
            ->method('flush');

        // 执行命令
        $this->commandTester->execute([]);

        // 验证命令执行成功
        $this->assertEquals(0, $this->commandTester->getStatusCode());
    }

    public function testExecute_withErrorResponse_shouldNotPersistDevices(): void
    {
        // 创建测试Agent
        $agent = new Agent();

        // 配置AgentRepository返回测试Agent
        $this->agentRepository->expects($this->once())
            ->method('findAll')
            ->willReturn([$agent]);

        // 模拟错误API响应
        $errorResponse = [
            'errcode' => 1,
            'errmsg' => 'error',
        ];

        // 配置WorkService以返回错误响应
        $this->workService->expects($this->exactly(3))
            ->method('request')
            ->willReturn($errorResponse);

        // EntityManager不应该被调用来持久化或刷新实体
        $this->entityManager->expects($this->never())
            ->method('persist');

        $this->entityManager->expects($this->never())
            ->method('flush');

        // 执行命令
        $this->commandTester->execute([]);

        // 验证命令执行成功（命令本身不抛出异常）
        $this->assertEquals(0, $this->commandTester->getStatusCode());
    }
}
