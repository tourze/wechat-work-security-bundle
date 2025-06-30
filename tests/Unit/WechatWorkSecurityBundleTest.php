<?php

namespace WechatWorkSecurityBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\WechatWorkSecurityBundle;

class WechatWorkSecurityBundleTest extends TestCase
{
    public function testBundleInstantiation(): void
    {
        $bundle = new WechatWorkSecurityBundle();
        
        $this->assertInstanceOf(WechatWorkSecurityBundle::class, $bundle);
    }
}