<?php

namespace WechatWorkSecurityBundle\Tests\Enum;

use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Enum\TrustDeviceStatusEnum;

class TrustDeviceStatusEnumTest extends TestCase
{
    public function testEnumValues_shouldBeCorrect(): void
    {
        $this->assertSame(1, TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN->value);
        $this->assertSame(2, TrustDeviceStatusEnum::PENDING_INVITATION->value);
        $this->assertSame(3, TrustDeviceStatusEnum::PENDING_ADMIN_CONFIRMATION_AS_ENTERPRISE_DEVICE->value);
        $this->assertSame(4, TrustDeviceStatusEnum::PENDING_ADMIN_CONFIRMATION_AS_PERSONAL_DEVICE->value);
        $this->assertSame(5, TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE->value);
        $this->assertSame(6, TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_PERSONAL_DEVICE->value);
    }

    public function testGetLabel_shouldReturnCorrectLabel(): void
    {
        $this->assertSame('已导入未登录', TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN->getLabel());
        $this->assertSame('待邀请', TrustDeviceStatusEnum::PENDING_INVITATION->getLabel());
        $this->assertSame('待管理员确认为企业设备', TrustDeviceStatusEnum::PENDING_ADMIN_CONFIRMATION_AS_ENTERPRISE_DEVICE->getLabel());
        $this->assertSame('待管理员确认为个人设备', TrustDeviceStatusEnum::PENDING_ADMIN_CONFIRMATION_AS_PERSONAL_DEVICE->getLabel());
        $this->assertSame('已确认为可信企业设备', TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE->getLabel());
        $this->assertSame('已确认为可信个人设备', TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_PERSONAL_DEVICE->getLabel());
    }

    public function testCases_shouldReturnAllCases(): void
    {
        $cases = TrustDeviceStatusEnum::cases();

        $this->assertCount(6, $cases);
        $this->assertContainsOnlyInstancesOf(TrustDeviceStatusEnum::class, $cases);
        $this->assertSame(TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN, $cases[0]);
        $this->assertSame(TrustDeviceStatusEnum::PENDING_INVITATION, $cases[1]);
        $this->assertSame(TrustDeviceStatusEnum::PENDING_ADMIN_CONFIRMATION_AS_ENTERPRISE_DEVICE, $cases[2]);
        $this->assertSame(TrustDeviceStatusEnum::PENDING_ADMIN_CONFIRMATION_AS_PERSONAL_DEVICE, $cases[3]);
        $this->assertSame(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE, $cases[4]);
        $this->assertSame(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_PERSONAL_DEVICE, $cases[5]);
    }

    public function testGenOptions_shouldReturnCorrectOptions(): void
    {
        $options = TrustDeviceStatusEnum::genOptions();

        $this->assertCount(6, $options);
        $this->assertIsArray($options);

        // 检查第一个选项
        $this->assertArrayHasKey('value', $options[0]);
        $this->assertArrayHasKey('text', $options[0]);
        $this->assertSame(1, $options[0]['value']);
        $this->assertSame('已导入未登录', $options[0]['text']);

        // 检查最后一个选项
        $lastIndex = count($options) - 1;
        $this->assertSame(6, $options[$lastIndex]['value']);
        $this->assertSame('已确认为可信个人设备', $options[$lastIndex]['text']);
    }
}
