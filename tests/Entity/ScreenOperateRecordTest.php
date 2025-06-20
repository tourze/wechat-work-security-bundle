<?php

namespace WechatWorkSecurityBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Entity\ScreenOperateRecord;
use WechatWorkSecurityBundle\Enum\ScreenShotTypeEnum;

class ScreenOperateRecordTest extends TestCase
{
    private ScreenOperateRecord $entity;

    protected function setUp(): void
    {
        $this->entity = new ScreenOperateRecord();
    }

    public function test_getId_returns_zero_by_default(): void
    {
        $this->assertSame(0, $this->entity->getId());
    }

    public function test_time_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getTime());

        $time = new \DateTime('2024-01-01 12:00:00');
        $this->entity->setTime($time);
        
        $this->assertSame($time, $this->entity->getTime());
    }

    public function test_userid_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getUserid());

        $userid = 'test_user_123';
        $this->entity->setUserid($userid);
        
        $this->assertSame($userid, $this->entity->getUserid());
    }

    public function test_departmentId_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getDepartmentId());

        $departmentId = 12345;
        $this->entity->setDepartmentId($departmentId);
        
        $this->assertSame($departmentId, $this->entity->getDepartmentId());
    }

    public function test_screenShotType_getter_and_setter(): void
    {
        $this->assertSame(ScreenShotTypeEnum::CHAT, $this->entity->getScreenShotType());

        $screenShotType = ScreenShotTypeEnum::FILES;
        $this->entity->setScreenShotType($screenShotType);
        
        $this->assertSame($screenShotType, $this->entity->getScreenShotType());
    }

    public function test_screenShotType_setter_with_null(): void
    {
        $this->entity->setScreenShotType(null);
        $this->assertNull($this->entity->getScreenShotType());
    }

    public function test_screenShotType_has_default_value(): void
    {
        $freshEntity = new ScreenOperateRecord();
        $this->assertSame(ScreenShotTypeEnum::CHAT, $freshEntity->getScreenShotType());
    }

    public function test_screenShotContent_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getScreenShotContent());

        $content = 'Screenshot of chat conversation';
        $this->entity->setScreenShotContent($content);
        
        $this->assertSame($content, $this->entity->getScreenShotContent());
    }

    public function test_system_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getSystem());

        $system = 'Windows 11';
        $this->entity->setSystem($system);
        
        $this->assertSame($system, $this->entity->getSystem());
    }

    public function test_createTime_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getCreateTime());

        $createTime = new \DateTimeImmutable('2024-01-01 10:00:00');
        $this->entity->setCreateTime($createTime);
        
        $this->assertSame($createTime, $this->entity->getCreateTime());
    }

    public function test_updateTime_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getUpdateTime());

        $updateTime = new \DateTimeImmutable('2024-01-01 11:00:00');
        $this->entity->setUpdateTime($updateTime);
        
        $this->assertSame($updateTime, $this->entity->getUpdateTime());
    }

    public function test_entity_with_all_properties_set(): void
    {
        $time = new \DateTimeImmutable('2024-01-01 12:00:00');
        $createTime = new \DateTimeImmutable('2024-01-01 10:00:00');
        $updateTime = new \DateTimeImmutable('2024-01-01 11:00:00');
        
        $this->entity->setTime($time);
        $this->entity->setUserid('user123');
        $this->entity->setDepartmentId(12345);
        $this->entity->setScreenShotType(ScreenShotTypeEnum::CHAT);
        $this->entity->setScreenShotContent('Screenshot content');
        $this->entity->setSystem('macOS');
        $this->entity->setCreateTime($createTime);
        $this->entity->setUpdateTime($updateTime);

        $this->assertSame($time, $this->entity->getTime());
        $this->assertSame('user123', $this->entity->getUserid());
        $this->assertSame(12345, $this->entity->getDepartmentId());
        $this->assertSame(ScreenShotTypeEnum::CHAT, $this->entity->getScreenShotType());
        $this->assertSame('Screenshot content', $this->entity->getScreenShotContent());
        $this->assertSame('macOS', $this->entity->getSystem());
        $this->assertSame($createTime, $this->entity->getCreateTime());
        $this->assertSame($updateTime, $this->entity->getUpdateTime());
    }
} 