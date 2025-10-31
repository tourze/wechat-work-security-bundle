<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Enum;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\PHPUnitEnum\AbstractEnumTestCase;
use WechatWorkSecurityBundle\Enum\FileOperateDeviceCodeEnum;

/**
 * @internal
 */
#[CoversClass(FileOperateDeviceCodeEnum::class)]
final class FileOperateDeviceCodeEnumTest extends AbstractEnumTestCase
{
    public function testEnumCasesExist(): void
    {
        $cases = FileOperateDeviceCodeEnum::cases();

        $this->assertCount(2, $cases);
        $this->assertContains(FileOperateDeviceCodeEnum::FIRM, $cases);
        $this->assertContains(FileOperateDeviceCodeEnum::PERSONAGE, $cases);
    }

    public function testEnumValuesAreCorrect(): void
    {
        $this->assertSame(1, FileOperateDeviceCodeEnum::FIRM->value);
        $this->assertSame(2, FileOperateDeviceCodeEnum::PERSONAGE->value);
    }

    public function testGetLabelReturnsCorrectLabels(): void
    {
        $this->assertSame('企业可信设备', FileOperateDeviceCodeEnum::FIRM->getLabel());
        $this->assertSame('个人可信设备', FileOperateDeviceCodeEnum::PERSONAGE->getLabel());
    }

    public function testTryFromWithValidValues(): void
    {
        $this->assertSame(FileOperateDeviceCodeEnum::FIRM, FileOperateDeviceCodeEnum::tryFrom(1));
        $this->assertSame(FileOperateDeviceCodeEnum::PERSONAGE, FileOperateDeviceCodeEnum::tryFrom(2));
    }

    public function testFromWithValidValues(): void
    {
        $this->assertSame(FileOperateDeviceCodeEnum::FIRM, FileOperateDeviceCodeEnum::from(1));
        $this->assertSame(FileOperateDeviceCodeEnum::PERSONAGE, FileOperateDeviceCodeEnum::from(2));
    }

    public function testImplementsRequiredInterfaces(): void
    {
        $enum = FileOperateDeviceCodeEnum::FIRM;

        $this->assertInstanceOf(Labelable::class, $enum);
        $this->assertInstanceOf(Itemable::class, $enum);
        $this->assertInstanceOf(Selectable::class, $enum);
    }

    public function testTraitMethodsAreAvailable(): void
    {
        // 验证静态方法 genOptions 存在并返回预期的结构
        $options = FileOperateDeviceCodeEnum::genOptions();
        $this->assertCount(2, $options);
        $this->assertArrayHasKey(0, $options);
        $this->assertArrayHasKey(1, $options);

        // 验证实例方法 toSelectItem 存在并返回正确的键
        $item = FileOperateDeviceCodeEnum::FIRM->toSelectItem();
        $this->assertArrayHasKey('label', $item);
        $this->assertArrayHasKey('text', $item);
        $this->assertArrayHasKey('value', $item);
        $this->assertArrayHasKey('name', $item);

        // 验证实例方法 toArray 存在并返回正确的键
        $array = FileOperateDeviceCodeEnum::FIRM->toArray();
        $this->assertArrayHasKey('value', $array);
        $this->assertArrayHasKey('label', $array);
        $this->assertCount(2, $array);
    }

    public function testToSelectItemReturnsCorrectStructure(): void
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

    public function testToArrayReturnsCorrectStructure(): void
    {
        $array = FileOperateDeviceCodeEnum::FIRM->toArray();

        $this->assertArrayHasKey('value', $array);
        $this->assertArrayHasKey('label', $array);

        $this->assertSame(1, $array['value']);
        $this->assertSame('企业可信设备', $array['label']);
    }

    public function testGenOptionsReturnsArrayOfOptions(): void
    {
        $options = FileOperateDeviceCodeEnum::genOptions();
        $this->assertCount(2, $options);

        foreach ($options as $option) {
            $this->assertIsArray($option);
            $this->assertArrayHasKey('label', $option);
            $this->assertArrayHasKey('value', $option);
        }
    }
}
