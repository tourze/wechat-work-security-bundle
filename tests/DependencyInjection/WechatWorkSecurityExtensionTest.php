<?php

namespace WechatWorkSecurityBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use WechatWorkSecurityBundle\DependencyInjection\WechatWorkSecurityExtension;

class WechatWorkSecurityExtensionTest extends TestCase
{
    private WechatWorkSecurityExtension $extension;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->extension = new WechatWorkSecurityExtension();
        $this->container = new ContainerBuilder();
    }

    public function test_implements_extension_interface(): void
    {
        $this->assertInstanceOf(ExtensionInterface::class, $this->extension);
    }

    public function test_load_with_empty_config(): void
    {
        $this->extension->load([], $this->container);
        
        // 应该能正常加载而不抛出异常
        $this->assertTrue(true);
    }

    public function test_load_services_configuration(): void
    {
        $this->extension->load([], $this->container);
        
        // 检查是否有服务定义被加载
        $this->assertGreaterThan(0, count($this->container->getDefinitions()));
    }

    public function test_get_alias(): void
    {
        $this->assertEquals('wechat_work_security', $this->extension->getAlias());
    }

    public function test_container_compilation(): void
    {
        $this->extension->load([], $this->container);
        
        // 应该能正常编译而不抛出异常
        $this->container->compile();
        
        $this->assertTrue($this->container->isCompiled());
    }

    public function test_load_commands(): void
    {
        $this->extension->load([], $this->container);
        
        // 检查命令是否被注册
        $commandIds = [
            'WechatWorkSecurityBundle\Command\FileOperateRecordCommand',
            'WechatWorkSecurityBundle\Command\MemberOperateRecordCommand',
            'WechatWorkSecurityBundle\Command\ScreenOperateRecordCommand',
            'WechatWorkSecurityBundle\Command\TrustDeviceCommand'
        ];
        
        foreach ($commandIds as $commandId) {
            $this->assertTrue(
                $this->container->hasDefinition($commandId) || 
                $this->container->hasAlias($commandId),
                "Command service {$commandId} should be registered"
            );
        }
    }

    public function test_load_repositories(): void
    {
        $this->extension->load([], $this->container);
        
        // 检查仓储是否被注册
        $repositoryIds = [
            'WechatWorkSecurityBundle\Repository\FileOperateRecordRepository',
            'WechatWorkSecurityBundle\Repository\MemberOperateRecordRepository',
            'WechatWorkSecurityBundle\Repository\ScreenOperateRecordRepository',
            'WechatWorkSecurityBundle\Repository\TrustDeviceRepository'
        ];
        
        foreach ($repositoryIds as $repositoryId) {
            $this->assertTrue(
                $this->container->hasDefinition($repositoryId) || 
                $this->container->hasAlias($repositoryId),
                "Repository service {$repositoryId} should be registered"
            );
        }
    }

    public function test_load_requests(): void
    {
        $this->extension->load([], $this->container);
        
        // 检查请求类是否被注册
        $requestIds = [
            'WechatWorkSecurityBundle\Request\FileOperateRecordRequest',
            'WechatWorkSecurityBundle\Request\MemberOperateRecordRequest',
            'WechatWorkSecurityBundle\Request\ScreenOperateRecordRequest',
            'WechatWorkSecurityBundle\Request\TrustDeviceRequest'
        ];
        
        foreach ($requestIds as $requestId) {
            $this->assertTrue(
                $this->container->hasDefinition($requestId) || 
                $this->container->hasAlias($requestId),
                "Request service {$requestId} should be registered"
            );
        }
    }
}