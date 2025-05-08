<?php

namespace WechatWorkSecurityBundle\Tests\Enum;

use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Enum\TrustDeviceSourceEnum;

class TrustDeviceSourceEnumTest extends TestCase
{
    public function testEnumValues_shouldBeCorrect(): void
    {
        $this->assertSame(1, TrustDeviceSourceEnum::UNKNOWN->value);
        $this->assertSame(2, TrustDeviceSourceEnum::MEMBER_CONFIRMATION->value);
        $this->assertSame(3, TrustDeviceSourceEnum::ADMIN_IMPORT->value);
        $this->assertSame(4, TrustDeviceSourceEnum::MEMBER_SELF_DECLARATION->value);
    }

    public function testGetLabel_shouldReturnCorrectLabel(): void
    {
        $this->assertSame('未知', TrustDeviceSourceEnum::UNKNOWN->getLabel());
        $this->assertSame('成员确认', TrustDeviceSourceEnum::MEMBER_CONFIRMATION->getLabel());
        $this->assertSame('管理员导入', TrustDeviceSourceEnum::ADMIN_IMPORT->getLabel());
        $this->assertSame('成员自主申报', TrustDeviceSourceEnum::MEMBER_SELF_DECLARATION->getLabel());
    }

    public function testCases_shouldReturnAllCases(): void
    {
        $cases = TrustDeviceSourceEnum::cases();

        $this->assertCount(4, $cases);
        $this->assertContainsOnlyInstancesOf(TrustDeviceSourceEnum::class, $cases);
        $this->assertSame(TrustDeviceSourceEnum::UNKNOWN, $cases[0]);
        $this->assertSame(TrustDeviceSourceEnum::MEMBER_CONFIRMATION, $cases[1]);
        $this->assertSame(TrustDeviceSourceEnum::ADMIN_IMPORT, $cases[2]);
        $this->assertSame(TrustDeviceSourceEnum::MEMBER_SELF_DECLARATION, $cases[3]);
    }

    public function testGenOptions_shouldReturnCorrectOptions(): void
    {
        $options = TrustDeviceSourceEnum::genOptions();

        $this->assertCount(4, $options);
        $this->assertIsArray($options);

        // 检查第一个选项
        $this->assertArrayHasKey('value', $options[0]);
        $this->assertArrayHasKey('text', $options[0]);
        $this->assertSame(1, $options[0]['value']);
        $this->assertSame('未知', $options[0]['text']);

        // 检查最后一个选项
        $lastIndex = count($options) - 1;
        $this->assertSame(4, $options[$lastIndex]['value']);
        $this->assertSame('成员自主申报', $options[$lastIndex]['text']);
    }
}
