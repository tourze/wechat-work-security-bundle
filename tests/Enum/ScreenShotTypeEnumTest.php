<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Enum;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\PHPUnitEnum\AbstractEnumTestCase;
use WechatWorkSecurityBundle\Enum\ScreenShotTypeEnum;

/**
 * @internal
 */
#[CoversClass(ScreenShotTypeEnum::class)]
final class ScreenShotTypeEnumTest extends AbstractEnumTestCase
{
    public function testEnumCasesExist(): void
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

    public function testEnumValuesAreCorrect(): void
    {
        $this->assertSame(1, ScreenShotTypeEnum::CHAT->value);
        $this->assertSame(2, ScreenShotTypeEnum::CONTACTS->value);
        $this->assertSame(3, ScreenShotTypeEnum::MAIL->value);
        $this->assertSame(4, ScreenShotTypeEnum::FILES->value);
        $this->assertSame(5, ScreenShotTypeEnum::SCHEDULE->value);
        $this->assertSame(6, ScreenShotTypeEnum::OTHERS->value);
    }

    public function testGetLabelReturnsCorrectLabels(): void
    {
        $this->assertSame('聊天', ScreenShotTypeEnum::CHAT->getLabel());
        $this->assertSame('通讯录', ScreenShotTypeEnum::CONTACTS->getLabel());
        $this->assertSame('邮箱', ScreenShotTypeEnum::MAIL->getLabel());
        $this->assertSame('文件', ScreenShotTypeEnum::FILES->getLabel());
        $this->assertSame('日程', ScreenShotTypeEnum::SCHEDULE->getLabel());
        $this->assertSame('其他', ScreenShotTypeEnum::OTHERS->getLabel());
    }

    public function testTryFromWithValidValues(): void
    {
        $this->assertSame(ScreenShotTypeEnum::CHAT, ScreenShotTypeEnum::tryFrom(1));
        $this->assertSame(ScreenShotTypeEnum::CONTACTS, ScreenShotTypeEnum::tryFrom(2));
        $this->assertSame(ScreenShotTypeEnum::MAIL, ScreenShotTypeEnum::tryFrom(3));
        $this->assertSame(ScreenShotTypeEnum::FILES, ScreenShotTypeEnum::tryFrom(4));
        $this->assertSame(ScreenShotTypeEnum::SCHEDULE, ScreenShotTypeEnum::tryFrom(5));
        $this->assertSame(ScreenShotTypeEnum::OTHERS, ScreenShotTypeEnum::tryFrom(6));
    }

    public function testFromWithValidValues(): void
    {
        $this->assertSame(ScreenShotTypeEnum::CHAT, ScreenShotTypeEnum::from(1));
        $this->assertSame(ScreenShotTypeEnum::OTHERS, ScreenShotTypeEnum::from(6));
    }

    public function testImplementsRequiredInterfaces(): void
    {
        $enum = ScreenShotTypeEnum::CHAT;

        $this->assertInstanceOf(Labelable::class, $enum);
        $this->assertInstanceOf(Itemable::class, $enum);
        $this->assertInstanceOf(Selectable::class, $enum);
    }

    public function testTraitMethodsAreAvailable(): void
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

    public function testToSelectItemReturnsCorrectStructure(): void
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

    public function testToArrayReturnsCorrectStructure(): void
    {
        $array = ScreenShotTypeEnum::CHAT->toArray();
        $this->assertArrayHasKey('value', $array);
        $this->assertArrayHasKey('label', $array);
        $this->assertCount(2, $array);
        $this->assertSame(1, $array['value']);
        $this->assertSame('聊天', $array['label']);

        $array = ScreenShotTypeEnum::OTHERS->toArray();
        $this->assertSame(6, $array['value']);
        $this->assertSame('其他', $array['label']);
    }

    public function testGenOptionsReturnsArrayOfOptions(): void
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
