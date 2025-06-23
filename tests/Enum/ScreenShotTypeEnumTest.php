<?php

namespace WechatWorkSecurityBundle\Tests\Enum;

use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Enum\ScreenShotTypeEnum;

class ScreenShotTypeEnumTest extends TestCase
{
    public function test_enum_cases_exist(): void
    {
        $cases = ScreenShotTypeEnum::cases();

        $this->assertCount(6, $cases);
        $this->assertContains(ScreenShotTypeEnum::CHAT, $cases);
        $this->assertContains(ScreenShotTypeEnum::CONTACTS, $cases);
        $this->assertContains(ScreenShotTypeEnum::MAIL, $cases);
        $this->assertContains(ScreenShotTypeEnum::FILES, $cases);
        $this->assertContains(ScreenShotTypeEnum::SCHEDULE, $cases);
        $this->assertContains(ScreenShotTypeEnum::OTHERS, $cases);
    }

    public function test_enum_values_are_correct(): void
    {
        $this->assertSame(1, ScreenShotTypeEnum::CHAT->value);
        $this->assertSame(2, ScreenShotTypeEnum::CONTACTS->value);
        $this->assertSame(3, ScreenShotTypeEnum::MAIL->value);
        $this->assertSame(4, ScreenShotTypeEnum::FILES->value);
        $this->assertSame(5, ScreenShotTypeEnum::SCHEDULE->value);
        $this->assertSame(6, ScreenShotTypeEnum::OTHERS->value);
    }

    public function test_getLabel_returns_correct_labels(): void
    {
        $this->assertSame('聊天', ScreenShotTypeEnum::CHAT->getLabel());
        $this->assertSame('通讯录', ScreenShotTypeEnum::CONTACTS->getLabel());
        $this->assertSame('邮箱', ScreenShotTypeEnum::MAIL->getLabel());
        $this->assertSame('文件', ScreenShotTypeEnum::FILES->getLabel());
        $this->assertSame('日程', ScreenShotTypeEnum::SCHEDULE->getLabel());
        $this->assertSame('其他', ScreenShotTypeEnum::OTHERS->getLabel());
    }

    public function test_tryFrom_with_valid_values(): void
    {
        $this->assertSame(ScreenShotTypeEnum::CHAT, ScreenShotTypeEnum::tryFrom(1));
        $this->assertSame(ScreenShotTypeEnum::CONTACTS, ScreenShotTypeEnum::tryFrom(2));
        $this->assertSame(ScreenShotTypeEnum::MAIL, ScreenShotTypeEnum::tryFrom(3));
        $this->assertSame(ScreenShotTypeEnum::FILES, ScreenShotTypeEnum::tryFrom(4));
        $this->assertSame(ScreenShotTypeEnum::SCHEDULE, ScreenShotTypeEnum::tryFrom(5));
        $this->assertSame(ScreenShotTypeEnum::OTHERS, ScreenShotTypeEnum::tryFrom(6));
    }

    public function test_tryFrom_with_invalid_value_returns_null(): void
    {
        $this->assertNull(ScreenShotTypeEnum::tryFrom(0));
        $this->assertNull(ScreenShotTypeEnum::tryFrom(7));
        $this->assertNull(ScreenShotTypeEnum::tryFrom(-1));
    }

    public function test_from_with_valid_values(): void
    {
        $this->assertSame(ScreenShotTypeEnum::CHAT, ScreenShotTypeEnum::from(1));
        $this->assertSame(ScreenShotTypeEnum::OTHERS, ScreenShotTypeEnum::from(6));
    }

    public function test_from_with_invalid_value_throws_exception(): void
    {
        $this->expectException(\ValueError::class);
        ScreenShotTypeEnum::from(999);
    }

    public function test_implements_required_interfaces(): void
    {
        $enum = ScreenShotTypeEnum::CHAT;

        $this->assertInstanceOf(\Tourze\EnumExtra\Labelable::class, $enum);
        $this->assertInstanceOf(\Tourze\EnumExtra\Itemable::class, $enum);
        $this->assertInstanceOf(\Tourze\EnumExtra\Selectable::class, $enum);
    }

    public function test_trait_methods_are_available(): void
    {
        // 验证静态方法 genOptions 存在并返回预期的结构
        $options = ScreenShotTypeEnum::genOptions();
        $this->assertCount(6, $options);
        $this->assertArrayHasKey(0, $options);
        $this->assertArrayHasKey(5, $options);

        // 验证实例方法 toSelectItem 存在并返回正确的键
        $item = ScreenShotTypeEnum::CHAT->toSelectItem();
        $this->assertArrayHasKey('label', $item);
        $this->assertArrayHasKey('text', $item);
        $this->assertArrayHasKey('value', $item);
        $this->assertArrayHasKey('name', $item);

        // 验证实例方法 toArray 存在并返回正确的键
        $array = ScreenShotTypeEnum::CHAT->toArray();
        $this->assertArrayHasKey('value', $array);
        $this->assertArrayHasKey('label', $array);
        $this->assertCount(2, $array);
    }

    public function test_toSelectItem_returns_correct_structure(): void
    {
        $item = ScreenShotTypeEnum::CHAT->toSelectItem();

        $this->assertArrayHasKey('label', $item);
        $this->assertArrayHasKey('text', $item);
        $this->assertArrayHasKey('value', $item);
        $this->assertArrayHasKey('name', $item);

        $this->assertSame('聊天', $item['label']);
        $this->assertSame('聊天', $item['text']);
        $this->assertSame(1, $item['value']);
        $this->assertSame('聊天', $item['name']);
    }

    public function test_genOptions_returns_array_of_options(): void
    {
        $options = ScreenShotTypeEnum::genOptions();
        $this->assertCount(6, $options);

        foreach ($options as $option) {
            $this->assertIsArray($option);
            $this->assertArrayHasKey('label', $option);
            $this->assertArrayHasKey('value', $option);
        }
    }
}
