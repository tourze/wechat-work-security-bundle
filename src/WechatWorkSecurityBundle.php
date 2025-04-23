<?php

namespace WechatWorkSecurityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\BundleDependency\BundleDependencyInterface;
use Tourze\EasyAdmin\Attribute\Permission\AsPermission;

#[AsPermission(title: '安全管理')]
class WechatWorkSecurityBundle extends Bundle implements BundleDependencyInterface
{
    public static function getBundleDependencies(): array
    {
        return [
            \WechatWorkBundle\WechatWorkBundle::class => ['all' => true],
        ];
    }
}
