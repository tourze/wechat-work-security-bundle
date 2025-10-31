<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;
use WechatWorkSecurityBundle\WechatWorkSecurityBundle;

/**
 * @internal
 * @phpstan-ignore symplify.forbiddenExtendOfNonAbstractClass
 */
#[CoversClass(WechatWorkSecurityBundle::class)]
#[RunTestsInSeparateProcesses]
final class WechatWorkSecurityBundleTest extends AbstractBundleTestCase
{
}
