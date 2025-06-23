<?php

namespace WechatWorkSecurityBundle\Tests\Enum;

use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Enum\TrustDeviceSourceEnum;

class TrustDeviceSourceEnumTest extends TestCase
{
    public function test_enum_cases_exist(): void
    {
        $cases = TrustDeviceSourceEnum::cases();

        $this->assertCount(4, $cases);
        $this->assertContains(TrustDeviceSourceEnum::UNKNOWN, $cases);
        $this->assertContains(TrustDeviceSourceEnum::MEMBER_CONFIRMATION, $cases);
        $this->assertContains(TrustDeviceSourceEnum::ADMIN_IMPORT, $cases);
        $this->assertContains(TrustDeviceSourceEnum::MEMBER_SELF_DECLARATION, $cases);
    }

    public function test_enum_values_are_correct(): void
    {
        $this->assertSame(1, TrustDeviceSourceEnum::UNKNOWN->value);
        $this->assertSame(2, TrustDeviceSourceEnum::MEMBER_CONFIRMATION->value);
        $this->assertSame(3, TrustDeviceSourceEnum::ADMIN_IMPORT->value);
        $this->assertSame(4, TrustDeviceSourceEnum::MEMBER_SELF_DECLARATION->value);
    }

    public function test_getLabel_returns_correct_labels(): void
    {
        $this->assertSame('未知', TrustDeviceSourceEnum::UNKNOWN->getLabel());
        $this->assertSame('成员确认', TrustDeviceSourceEnum::MEMBER_CONFIRMATION->getLabel());
        $this->assertSame('管理员导入', TrustDeviceSourceEnum::ADMIN_IMPORT->getLabel());
        $this->assertSame('成员自主申报', TrustDeviceSourceEnum::MEMBER_SELF_DECLARATION->getLabel());
    }

    public function test_tryFrom_with_valid_values(): void
    {
        $this->assertSame(TrustDeviceSourceEnum::UNKNOWN, TrustDeviceSourceEnum::tryFrom(1));
        $this->assertSame(TrustDeviceSourceEnum::MEMBER_CONFIRMATION, TrustDeviceSourceEnum::tryFrom(2));
        $this->assertSame(TrustDeviceSourceEnum::ADMIN_IMPORT, TrustDeviceSourceEnum::tryFrom(3));
        $this->assertSame(TrustDeviceSourceEnum::MEMBER_SELF_DECLARATION, TrustDeviceSourceEnum::tryFrom(4));
    }

    public function test_tryFrom_with_invalid_value_returns_null(): void
    {
        $this->assertNull(TrustDeviceSourceEnum::tryFrom(0));
        $this->assertNull(TrustDeviceSourceEnum::tryFrom(5));
        $this->assertNull(TrustDeviceSourceEnum::tryFrom(-1));
    }

    public function test_from_with_valid_values(): void
    {
        $this->assertSame(TrustDeviceSourceEnum::UNKNOWN, TrustDeviceSourceEnum::from(1));
        $this->assertSame(TrustDeviceSourceEnum::MEMBER_SELF_DECLARATION, TrustDeviceSourceEnum::from(4));
    }

    public function test_from_with_invalid_value_throws_exception(): void
    {
        $this->expectException(\ValueError::class);
        TrustDeviceSourceEnum::from(999);
    }

    public function test_implements_required_interfaces(): void
    {
        $enum = TrustDeviceSourceEnum::UNKNOWN;

        $this->assertInstanceOf(\Tourze\EnumExtra\Labelable::class, $enum);
        $this->assertInstanceOf(\Tourze\EnumExtra\Itemable::class, $enum);
        $this->assertInstanceOf(\Tourze\EnumExtra\Selectable::class, $enum);
    }

    public function test_trait_methods_are_available(): void
    {
        // 验证静态方法 genOptions 存在并返回预期的结构
        $options = TrustDeviceSourceEnum::genOptions();
        $this->assertCount(4, $options);
        $this->assertArrayHasKey(0, $options);
        $this->assertArrayHasKey(3, $options);

        // 验证实例方法 toSelectItem 存在并返回正确的键
        $item = TrustDeviceSourceEnum::UNKNOWN->toSelectItem();
        $this->assertArrayHasKey('label', $item);
        $this->assertArrayHasKey('text', $item);
        $this->assertArrayHasKey('value', $item);
        $this->assertArrayHasKey('name', $item);

        // 验证实例方法 toArray 存在并返回正确的键
        $array = TrustDeviceSourceEnum::UNKNOWN->toArray();
        $this->assertArrayHasKey('value', $array);
        $this->assertArrayHasKey('label', $array);
        $this->assertCount(2, $array);
    }

    public function test_toSelectItem_returns_correct_structure(): void
    {
        $item = TrustDeviceSourceEnum::UNKNOWN->toSelectItem();

        $this->assertArrayHasKey('label', $item);
        $this->assertArrayHasKey('text', $item);
        $this->assertArrayHasKey('value', $item);
        $this->assertArrayHasKey('name', $item);

        $this->assertSame('未知', $item['label']);
        $this->assertSame('未知', $item['text']);
        $this->assertSame(1, $item['value']);
        $this->assertSame('未知', $item['name']);
    }

    public function test_genOptions_returns_array_of_options(): void
    {
        $options = TrustDeviceSourceEnum::genOptions();
        $this->assertCount(4, $options);

        foreach ($options as $option) {
            $this->assertIsArray($option);
            $this->assertArrayHasKey('label', $option);
            $this->assertArrayHasKey('value', $option);
        }
    }
}
