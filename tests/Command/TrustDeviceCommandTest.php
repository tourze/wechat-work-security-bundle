<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Command;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use WechatWorkSecurityBundle\Command\TrustDeviceCommand;

/**
 * @internal
 */
#[CoversClass(TrustDeviceCommand::class)]
#[RunTestsInSeparateProcesses]
final class TrustDeviceCommandTest extends AbstractCommandTestCase
{
    protected function onSetUp(): void
    {
        // 无需特殊设置
    }

    protected function getCommandTester(): CommandTester
    {
        $command = self::getService(TrustDeviceCommand::class);
        $this->assertInstanceOf(TrustDeviceCommand::class, $command);

        return new CommandTester($command);
    }

    public function testCommandBasicProperties(): void
    {
        $command = self::getService(TrustDeviceCommand::class);
        $this->assertSame('wechat-work:trust-device', $command->getName());
        $this->assertSame('获取设备信息', $command->getDescription());
    }

    public function testCommandCanBeInstantiated(): void
    {
        $command = self::getService(TrustDeviceCommand::class);
        $this->assertInstanceOf(TrustDeviceCommand::class, $command);
        $this->assertInstanceOf(Command::class, $command);
    }

    public function testCommandHasCorrectDefinition(): void
    {
        $command = self::getService(TrustDeviceCommand::class);
        $definition = $command->getDefinition();

        $this->assertNotNull($definition);
        $this->assertIsString($command->getHelp());
    }

    public function testCommandIsConfiguredProperly(): void
    {
        $command = self::getService(TrustDeviceCommand::class);
        $this->assertTrue($command->isEnabled());
        $this->assertNotEmpty($command->getName());
        $this->assertNotEmpty($command->getDescription());
    }

    public function testCommandTesterUsage(): void
    {
        $commandTester = $this->getCommandTester();
        $this->assertInstanceOf(CommandTester::class, $commandTester);
    }
}
