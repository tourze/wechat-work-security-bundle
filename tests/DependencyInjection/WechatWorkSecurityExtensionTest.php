<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Tourze\PHPUnitSymfonyUnitTest\AbstractDependencyInjectionExtensionTestCase;
use WechatWorkSecurityBundle\DependencyInjection\WechatWorkSecurityExtension;

/**
 * @internal
 */
#[CoversClass(WechatWorkSecurityExtension::class)]
final class WechatWorkSecurityExtensionTest extends AbstractDependencyInjectionExtensionTestCase
{
    public function testImplementsExtensionInterface(): void
    {
        $extension = new WechatWorkSecurityExtension();
        $this->assertInstanceOf(ExtensionInterface::class, $extension);
    }

    public function testLoadWithEmptyConfig(): void
    {
        $extension = new WechatWorkSecurityExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.environment', 'test');
        $container->setParameter('kernel.project_dir', __DIR__ . '/../../');

        $extension->load([], $container);

        // 验证容器中至少加载了一些服务定义
        $this->assertGreaterThan(0, count($container->getDefinitions()));
    }

    public function testGetAlias(): void
    {
        $extension = new WechatWorkSecurityExtension();
        $this->assertEquals('wechat_work_security', $extension->getAlias());
    }

    public function testContainerCompilation(): void
    {
        $extension = new WechatWorkSecurityExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.environment', 'test');
        $container->setParameter('kernel.project_dir', __DIR__ . '/../../');

        // 注册AdminMenu需要的依赖服务的Mock
        $container->register('Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface')
            ->setSynthetic(true)
        ;

        $extension->load([], $container);

        // 应该能正常编译而不抛出异常
        $container->compile();

        $this->assertTrue($container->isCompiled());
    }

    public function testLoadCommands(): void
    {
        $extension = new WechatWorkSecurityExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.environment', 'test');
        $container->setParameter('kernel.project_dir', __DIR__ . '/../../');

        $extension->load([], $container);

        // 检查命令是否被注册
        $commandIds = [
            'WechatWorkSecurityBundle\Command\FileOperateRecordCommand',
            'WechatWorkSecurityBundle\Command\MemberOperateRecordCommand',
            'WechatWorkSecurityBundle\Command\ScreenOperateRecordCommand',
            'WechatWorkSecurityBundle\Command\TrustDeviceCommand',
        ];

        foreach ($commandIds as $commandId) {
            $this->assertTrue(
                $container->hasDefinition($commandId)
                || $container->hasAlias($commandId),
                "Command service {$commandId} should be registered"
            );
        }
    }

    public function testLoadRepositories(): void
    {
        $extension = new WechatWorkSecurityExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.environment', 'test');
        $container->setParameter('kernel.project_dir', __DIR__ . '/../../');

        $extension->load([], $container);

        // 检查仓储是否被注册
        $repositoryIds = [
            'WechatWorkSecurityBundle\Repository\FileOperateRecordRepository',
            'WechatWorkSecurityBundle\Repository\MemberOperateRecordRepository',
            'WechatWorkSecurityBundle\Repository\ScreenOperateRecordRepository',
            'WechatWorkSecurityBundle\Repository\TrustDeviceRepository',
        ];

        foreach ($repositoryIds as $repositoryId) {
            $this->assertTrue(
                $container->hasDefinition($repositoryId)
                || $container->hasAlias($repositoryId),
                "Repository service {$repositoryId} should be registered"
            );
        }
    }

    public function testLoadRequests(): void
    {
        $extension = new WechatWorkSecurityExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.environment', 'test');
        $container->setParameter('kernel.project_dir', __DIR__ . '/../../');

        $extension->load([], $container);

        // 检查请求类是否被注册
        $requestIds = [
            'WechatWorkSecurityBundle\Request\FileOperateRecordRequest',
            'WechatWorkSecurityBundle\Request\MemberOperateRecordRequest',
            'WechatWorkSecurityBundle\Request\ScreenOperateRecordRequest',
            'WechatWorkSecurityBundle\Request\TrustDeviceRequest',
        ];

        foreach ($requestIds as $requestId) {
            $this->assertTrue(
                $container->hasDefinition($requestId)
                || $container->hasAlias($requestId),
                "Request service {$requestId} should be registered"
            );
        }
    }
}
