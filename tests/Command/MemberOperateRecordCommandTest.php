<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Command;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Tourze\PHPUnitSymfonyKernelTest\AbstractCommandTestCase;
use WechatWorkSecurityBundle\Command\MemberOperateRecordCommand;

/**
 * @internal
 */
#[CoversClass(MemberOperateRecordCommand::class)]
#[RunTestsInSeparateProcesses]
final class MemberOperateRecordCommandTest extends AbstractCommandTestCase
{
    protected function onSetUp(): void
    {
        // 无需特殊设置
    }

    protected function getCommandTester(): CommandTester
    {
        $command = self::getService(MemberOperateRecordCommand::class);
        $this->assertInstanceOf(MemberOperateRecordCommand::class, $command);

        return new CommandTester($command);
    }

    public function testArgumentStartTime(): void
    {
        $command = self::getService(MemberOperateRecordCommand::class);
        $definition = $command->getDefinition();

        $this->assertTrue($definition->hasArgument('startTime'));

        $argument = $definition->getArgument('startTime');
        $this->assertFalse($argument->isRequired());
        $this->assertSame('order start time', $argument->getDescription());
    }

    public function testArgumentEndTime(): void
    {
        $command = self::getService(MemberOperateRecordCommand::class);
        $definition = $command->getDefinition();

        $this->assertTrue($definition->hasArgument('endTime'));

        $argument = $definition->getArgument('endTime');
        $this->assertFalse($argument->isRequired());
        $this->assertSame('order end time', $argument->getDescription());
    }

    public function testCommandBasicProperties(): void
    {
        $command = self::getService(MemberOperateRecordCommand::class);
        $this->assertSame('wechat-work:member-operate-record', $command->getName());
        $this->assertSame('获取成员操作记录', $command->getDescription());
    }

    public function testCommandCanBeInstantiated(): void
    {
        $command = self::getService(MemberOperateRecordCommand::class);
        $this->assertInstanceOf(MemberOperateRecordCommand::class, $command);
        $this->assertInstanceOf(Command::class, $command);
    }

    public function testCommandHasCorrectDefinition(): void
    {
        $command = self::getService(MemberOperateRecordCommand::class);
        $definition = $command->getDefinition();

        $this->assertNotNull($definition);
        $this->assertIsString($command->getHelp());
    }

    public function testCommandIsConfiguredProperly(): void
    {
        $command = self::getService(MemberOperateRecordCommand::class);
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
