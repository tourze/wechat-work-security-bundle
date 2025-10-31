<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use EasyCorp\Bundle\EasyAdminBundle\EasyAdminBundle;
use HttpClientBundle\HttpClientBundle;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\BundleDependency\BundleDependencyInterface;
use Tourze\EasyAdminMenuBundle\EasyAdminMenuBundle;
use WechatWorkBundle\WechatWorkBundle;

class WechatWorkSecurityBundle extends Bundle implements BundleDependencyInterface
{
    public static function getBundleDependencies(): array
    {
        return [
            DoctrineBundle::class => ['all' => true],
            TwigBundle::class => ['all' => true],
            EasyAdminBundle::class => ['all' => true],
            EasyAdminMenuBundle::class => ['all' => true],
            HttpClientBundle::class => ['all' => true],
            WechatWorkBundle::class => ['all' => true],
        ];
    }
}
