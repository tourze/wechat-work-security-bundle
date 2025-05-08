<?php

namespace WechatWorkSecurityBundle\Tests\Enum;

use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Enum\FileOperateDeviceCodeEnum;

class FileOperateDeviceCodeEnumTest extends TestCase
{
    public function testEnumValues_shouldBeCorrect(): void
    {
        $this->assertSame(1, FileOperateDeviceCodeEnum::FIRM->value);
        $this->assertSame(2, FileOperateDeviceCodeEnum::PERSONAGE->value);
    }

    public function testGetLabel_shouldReturnCorrectLabel(): void
    {
        $this->assertSame('企业可信设备', FileOperateDeviceCodeEnum::FIRM->getLabel());
        $this->assertSame('个人可信设备', FileOperateDeviceCodeEnum::PERSONAGE->getLabel());
    }

    public function testCases_shouldReturnAllCases(): void
    {
        $cases = FileOperateDeviceCodeEnum::cases();

        $this->assertCount(2, $cases);
        $this->assertContainsOnlyInstancesOf(FileOperateDeviceCodeEnum::class, $cases);
        $this->assertSame(FileOperateDeviceCodeEnum::FIRM, $cases[0]);
        $this->assertSame(FileOperateDeviceCodeEnum::PERSONAGE, $cases[1]);
    }

    public function testGenOptions_shouldReturnCorrectOptions(): void
    {
        $options = FileOperateDeviceCodeEnum::genOptions();

        $this->assertCount(2, $options);
        $this->assertIsArray($options);

        $this->assertArrayHasKey('value', $options[0]);
        $this->assertArrayHasKey('text', $options[0]);
        $this->assertSame(1, $options[0]['value']);
        $this->assertSame('企业可信设备', $options[0]['text']);

        $this->assertSame(2, $options[1]['value']);
        $this->assertSame('个人可信设备', $options[1]['text']);
    }
}
