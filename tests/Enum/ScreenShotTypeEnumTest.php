<?php

namespace WechatWorkSecurityBundle\Tests\Enum;

use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Enum\ScreenShotTypeEnum;

class ScreenShotTypeEnumTest extends TestCase
{
    public function testEnumValues_shouldBeCorrect(): void
    {
        $this->assertSame(1, ScreenShotTypeEnum::CHAT->value);
        $this->assertSame(2, ScreenShotTypeEnum::CONTACTS->value);
        $this->assertSame(3, ScreenShotTypeEnum::MAIL->value);
        $this->assertSame(4, ScreenShotTypeEnum::FILES->value);
        $this->assertSame(5, ScreenShotTypeEnum::SCHEDULE->value);
        $this->assertSame(6, ScreenShotTypeEnum::OTHERS->value);
    }

    public function testGetLabel_shouldReturnCorrectLabel(): void
    {
        $this->assertSame('聊天', ScreenShotTypeEnum::CHAT->getLabel());
        $this->assertSame('通讯录', ScreenShotTypeEnum::CONTACTS->getLabel());
        $this->assertSame('邮箱', ScreenShotTypeEnum::MAIL->getLabel());
        $this->assertSame('文件', ScreenShotTypeEnum::FILES->getLabel());
        $this->assertSame('日程', ScreenShotTypeEnum::SCHEDULE->getLabel());
        $this->assertSame('其他', ScreenShotTypeEnum::OTHERS->getLabel());
    }

    public function testCases_shouldReturnAllCases(): void
    {
        $cases = ScreenShotTypeEnum::cases();

        $this->assertCount(6, $cases);
        $this->assertContainsOnlyInstancesOf(ScreenShotTypeEnum::class, $cases);
        $this->assertSame(ScreenShotTypeEnum::CHAT, $cases[0]);
        $this->assertSame(ScreenShotTypeEnum::CONTACTS, $cases[1]);
        $this->assertSame(ScreenShotTypeEnum::MAIL, $cases[2]);
        $this->assertSame(ScreenShotTypeEnum::FILES, $cases[3]);
        $this->assertSame(ScreenShotTypeEnum::SCHEDULE, $cases[4]);
        $this->assertSame(ScreenShotTypeEnum::OTHERS, $cases[5]);
    }

    public function testGenOptions_shouldReturnCorrectOptions(): void
    {
        $options = ScreenShotTypeEnum::genOptions();

        $this->assertCount(6, $options);
        $this->assertIsArray($options);

        // 检查第一个选项
        $this->assertArrayHasKey('value', $options[0]);
        $this->assertArrayHasKey('text', $options[0]);
        $this->assertSame(1, $options[0]['value']);
        $this->assertSame('聊天', $options[0]['text']);
    }
}
