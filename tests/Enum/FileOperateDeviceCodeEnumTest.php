<?php

namespace WechatWorkSecurityBundle\Tests\Enum;

use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Enum\FileOperateDeviceCodeEnum;

class FileOperateDeviceCodeEnumTest extends TestCase
{
    public function test_enum_cases_exist(): void
    {
        $cases = FileOperateDeviceCodeEnum::cases();

        $this->assertCount(2, $cases);
        $this->assertContains(FileOperateDeviceCodeEnum::FIRM, $cases);
        $this->assertContains(FileOperateDeviceCodeEnum::PERSONAGE, $cases);
    }

    public function test_enum_values_are_correct(): void
    {
        $this->assertSame(1, FileOperateDeviceCodeEnum::FIRM->value);
        $this->assertSame(2, FileOperateDeviceCodeEnum::PERSONAGE->value);
    }

    public function test_getLabel_returns_correct_labels(): void
    {
        $this->assertSame('企业可信设备', FileOperateDeviceCodeEnum::FIRM->getLabel());
        $this->assertSame('个人可信设备', FileOperateDeviceCodeEnum::PERSONAGE->getLabel());
    }

    public function test_tryFrom_with_valid_values(): void
    {
        $this->assertSame(FileOperateDeviceCodeEnum::FIRM, FileOperateDeviceCodeEnum::tryFrom(1));
        $this->assertSame(FileOperateDeviceCodeEnum::PERSONAGE, FileOperateDeviceCodeEnum::tryFrom(2));
    }

    public function test_tryFrom_with_invalid_value_returns_null(): void
    {
        $this->assertNull(FileOperateDeviceCodeEnum::tryFrom(0));
        $this->assertNull(FileOperateDeviceCodeEnum::tryFrom(3));
        $this->assertNull(FileOperateDeviceCodeEnum::tryFrom(-1));
    }

    public function test_from_with_valid_values(): void
    {
        $this->assertSame(FileOperateDeviceCodeEnum::FIRM, FileOperateDeviceCodeEnum::from(1));
        $this->assertSame(FileOperateDeviceCodeEnum::PERSONAGE, FileOperateDeviceCodeEnum::from(2));
    }

    public function test_from_with_invalid_value_throws_exception(): void
    {
        $this->expectException(\ValueError::class);
        FileOperateDeviceCodeEnum::from(999);
    }

    public function test_implements_required_interfaces(): void
    {
        $enum = FileOperateDeviceCodeEnum::FIRM;

        $this->assertInstanceOf(\Tourze\EnumExtra\Labelable::class, $enum);
        $this->assertInstanceOf(\Tourze\EnumExtra\Itemable::class, $enum);
        $this->assertInstanceOf(\Tourze\EnumExtra\Selectable::class, $enum);
    }

    public function test_trait_methods_are_available(): void
    {
        $this->assertTrue(is_callable([FileOperateDeviceCodeEnum::class, 'genOptions']));
        $this->assertTrue(is_callable([FileOperateDeviceCodeEnum::FIRM, 'toSelectItem']));
        $this->assertTrue(is_callable([FileOperateDeviceCodeEnum::FIRM, 'toArray']));
    }

    public function test_toSelectItem_returns_correct_structure(): void
    {
        $item = FileOperateDeviceCodeEnum::FIRM->toSelectItem();

        $this->assertArrayHasKey('label', $item);
        $this->assertArrayHasKey('text', $item);
        $this->assertArrayHasKey('value', $item);
        $this->assertArrayHasKey('name', $item);

        $this->assertSame('企业可信设备', $item['label']);
        $this->assertSame('企业可信设备', $item['text']);
        $this->assertSame(1, $item['value']);
        $this->assertSame('企业可信设备', $item['name']);
    }

    public function test_toArray_returns_correct_structure(): void
    {
        $array = FileOperateDeviceCodeEnum::FIRM->toArray();

        $this->assertArrayHasKey('value', $array);
        $this->assertArrayHasKey('label', $array);

        $this->assertSame(1, $array['value']);
        $this->assertSame('企业可信设备', $array['label']);
    }

    public function test_genOptions_returns_array_of_options(): void
    {
        $options = FileOperateDeviceCodeEnum::genOptions();
        $this->assertCount(2, $options);

        foreach ($options as $option) {
            $this->assertArrayHasKey('label', $option);
            $this->assertArrayHasKey('value', $option);
        }
    }
}
