<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\EasyAdminMenuBundle\Service\MenuProviderInterface;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminMenuTestCase;
use WechatWorkSecurityBundle\Service\AdminMenu;

/**
 * @internal
 */
#[CoversClass(AdminMenu::class)]
#[RunTestsInSeparateProcesses]
final class AdminMenuTest extends AbstractEasyAdminMenuTestCase
{
    protected function onSetUp(): void
    {
        // No specific setup required for AdminMenu tests
    }

    public function testServiceCanBeInstantiated(): void
    {
        $adminMenu = self::getService(AdminMenu::class);
        self::assertInstanceOf(AdminMenu::class, $adminMenu);
    }

    public function testMenuProviderInterface(): void
    {
        $adminMenu = self::getService(AdminMenu::class);
        self::assertInstanceOf(MenuProviderInterface::class, $adminMenu);
    }

    public function testServiceIntegration(): void
    {
        $adminMenu = self::getService(AdminMenu::class);
        self::assertInstanceOf(AdminMenu::class, $adminMenu);
    }
}
