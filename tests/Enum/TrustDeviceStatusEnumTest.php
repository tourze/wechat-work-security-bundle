<?php

namespace WechatWorkSecurityBundle\Tests\Enum;

use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Enum\TrustDeviceStatusEnum;

class TrustDeviceStatusEnumTest extends TestCase
{
    public function test_enum_cases_exist(): void
    {
        $cases = TrustDeviceStatusEnum::cases();

        $this->assertCount(6, $cases);
        $this->assertContains(TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN, $cases);
        $this->assertContains(TrustDeviceStatusEnum::PENDING_INVITATION, $cases);
        $this->assertContains(TrustDeviceStatusEnum::PENDING_ADMIN_CONFIRMATION_AS_ENTERPRISE_DEVICE, $cases);
        $this->assertContains(TrustDeviceStatusEnum::PENDING_ADMIN_CONFIRMATION_AS_PERSONAL_DEVICE, $cases);
        $this->assertContains(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE, $cases);
        $this->assertContains(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_PERSONAL_DEVICE, $cases);
    }

    public function test_enum_values_are_correct(): void
    {
        $this->assertSame(1, TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN->value);
        $this->assertSame(2, TrustDeviceStatusEnum::PENDING_INVITATION->value);
        $this->assertSame(3, TrustDeviceStatusEnum::PENDING_ADMIN_CONFIRMATION_AS_ENTERPRISE_DEVICE->value);
        $this->assertSame(4, TrustDeviceStatusEnum::PENDING_ADMIN_CONFIRMATION_AS_PERSONAL_DEVICE->value);
        $this->assertSame(5, TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE->value);
        $this->assertSame(6, TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_PERSONAL_DEVICE->value);
    }

    public function test_getLabel_returns_correct_labels(): void
    {
        $this->assertSame('已导入未登录', TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN->getLabel());
        $this->assertSame('待邀请', TrustDeviceStatusEnum::PENDING_INVITATION->getLabel());
        $this->assertSame('待管理员确认为企业设备', TrustDeviceStatusEnum::PENDING_ADMIN_CONFIRMATION_AS_ENTERPRISE_DEVICE->getLabel());
        $this->assertSame('待管理员确认为个人设备', TrustDeviceStatusEnum::PENDING_ADMIN_CONFIRMATION_AS_PERSONAL_DEVICE->getLabel());
        $this->assertSame('已确认为可信企业设备', TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE->getLabel());
        $this->assertSame('已确认为可信个人设备', TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_PERSONAL_DEVICE->getLabel());
    }

    public function test_tryFrom_with_valid_values(): void
    {
        $this->assertSame(TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN, TrustDeviceStatusEnum::tryFrom(1));
        $this->assertSame(TrustDeviceStatusEnum::PENDING_INVITATION, TrustDeviceStatusEnum::tryFrom(2));
        $this->assertSame(TrustDeviceStatusEnum::PENDING_ADMIN_CONFIRMATION_AS_ENTERPRISE_DEVICE, TrustDeviceStatusEnum::tryFrom(3));
        $this->assertSame(TrustDeviceStatusEnum::PENDING_ADMIN_CONFIRMATION_AS_PERSONAL_DEVICE, TrustDeviceStatusEnum::tryFrom(4));
        $this->assertSame(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE, TrustDeviceStatusEnum::tryFrom(5));
        $this->assertSame(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_PERSONAL_DEVICE, TrustDeviceStatusEnum::tryFrom(6));
    }

    public function test_tryFrom_with_invalid_value_returns_null(): void
    {
        $this->assertNull(TrustDeviceStatusEnum::tryFrom(0));
        $this->assertNull(TrustDeviceStatusEnum::tryFrom(7));
        $this->assertNull(TrustDeviceStatusEnum::tryFrom(-1));
    }

    public function test_from_with_valid_values(): void
    {
        $this->assertSame(TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN, TrustDeviceStatusEnum::from(1));
        $this->assertSame(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_PERSONAL_DEVICE, TrustDeviceStatusEnum::from(6));
    }

    public function test_from_with_invalid_value_throws_exception(): void
    {
        $this->expectException(\ValueError::class);
        TrustDeviceStatusEnum::from(999);
    }

    public function test_implements_required_interfaces(): void
    {
        $enum = TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN;

        $this->assertInstanceOf(\Tourze\EnumExtra\Labelable::class, $enum);
        $this->assertInstanceOf(\Tourze\EnumExtra\Itemable::class, $enum);
        $this->assertInstanceOf(\Tourze\EnumExtra\Selectable::class, $enum);
    }

    public function test_trait_methods_are_available(): void
    {
        // 验证静态方法 genOptions 存在并返回预期的结构
        $options = TrustDeviceStatusEnum::genOptions();
        $this->assertCount(6, $options);
        $this->assertArrayHasKey(0, $options);
        $this->assertArrayHasKey(5, $options);

        // 验证实例方法 toSelectItem 存在并返回正确的键
        $item = TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN->toSelectItem();
        $this->assertArrayHasKey('label', $item);
        $this->assertArrayHasKey('text', $item);
        $this->assertArrayHasKey('value', $item);
        $this->assertArrayHasKey('name', $item);

        // 验证实例方法 toArray 存在并返回正确的键
        $array = TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN->toArray();
        $this->assertArrayHasKey('value', $array);
        $this->assertArrayHasKey('label', $array);
        $this->assertCount(2, $array);
    }

    public function test_toSelectItem_returns_correct_structure(): void
    {
        $item = TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN->toSelectItem();

        $this->assertArrayHasKey('label', $item);
        $this->assertArrayHasKey('text', $item);
        $this->assertArrayHasKey('value', $item);
        $this->assertArrayHasKey('name', $item);

        $this->assertSame('已导入未登录', $item['label']);
        $this->assertSame('已导入未登录', $item['text']);
        $this->assertSame(1, $item['value']);
        $this->assertSame('已导入未登录', $item['name']);
    }

    public function test_genOptions_returns_array_of_options(): void
    {
        $options = TrustDeviceStatusEnum::genOptions();
        $this->assertCount(6, $options);

        foreach ($options as $option) {
            $this->assertIsArray($option);
            $this->assertArrayHasKey('label', $option);
            $this->assertArrayHasKey('value', $option);
        }
    }
}
