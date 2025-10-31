<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatWorkSecurityBundle\Entity\ScreenOperateRecord;
use WechatWorkSecurityBundle\Enum\ScreenShotTypeEnum;

/**
 * @internal
 */
#[CoversClass(ScreenOperateRecord::class)]
final class ScreenOperateRecordTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new ScreenOperateRecord();
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'userid' => ['userid', 'test_user_123'],
            'system' => ['system', 'Windows 11'],
            'screenShotContent' => ['screenShotContent', 'Screenshot content'],
        ];
    }

    public function testGetIdReturnsZeroByDefault(): void
    {
        $entity = new ScreenOperateRecord();
        $this->assertSame(0, $entity->getId());
    }

    public function testTimeGetterAndSetter(): void
    {
        $entity = new ScreenOperateRecord();
        $this->assertNull($entity->getTime());

        $time = new \DateTime('2024-01-01 12:00:00');
        $entity->setTime($time);

        $this->assertSame($time, $entity->getTime());
    }

    public function testUseridGetterAndSetter(): void
    {
        $entity = new ScreenOperateRecord();
        $this->assertNull($entity->getUserid());

        $userid = 'test_user_123';
        $entity->setUserid($userid);

        $this->assertSame($userid, $entity->getUserid());
    }

    public function testDepartmentIdGetterAndSetter(): void
    {
        $entity = new ScreenOperateRecord();
        $this->assertNull($entity->getDepartmentId());

        $departmentId = 12345;
        $entity->setDepartmentId($departmentId);

        $this->assertSame($departmentId, $entity->getDepartmentId());
    }

    public function testScreenShotTypeGetterAndSetter(): void
    {
        $entity = new ScreenOperateRecord();
        $this->assertSame(ScreenShotTypeEnum::CHAT, $entity->getScreenShotType());

        $screenShotType = ScreenShotTypeEnum::FILES;
        $entity->setScreenShotType($screenShotType);

        $this->assertSame($screenShotType, $entity->getScreenShotType());
    }

    public function testScreenShotTypeSetterWithNull(): void
    {
        $entity = new ScreenOperateRecord();
        $entity->setScreenShotType(null);
        $this->assertNull($entity->getScreenShotType());
    }

    public function testScreenShotTypeHasDefaultValue(): void
    {
        $freshEntity = new ScreenOperateRecord();
        $this->assertSame(ScreenShotTypeEnum::CHAT, $freshEntity->getScreenShotType());
    }

    public function testScreenShotContentGetterAndSetter(): void
    {
        $entity = new ScreenOperateRecord();
        $this->assertNull($entity->getScreenShotContent());

        $content = 'Screenshot of chat conversation';
        $entity->setScreenShotContent($content);

        $this->assertSame($content, $entity->getScreenShotContent());
    }

    public function testSystemGetterAndSetter(): void
    {
        $entity = new ScreenOperateRecord();
        $this->assertNull($entity->getSystem());

        $system = 'Windows 11';
        $entity->setSystem($system);

        $this->assertSame($system, $entity->getSystem());
    }

    public function testCreateTimeGetterAndSetter(): void
    {
        $entity = new ScreenOperateRecord();
        $this->assertNull($entity->getCreateTime());

        $createTime = new \DateTimeImmutable('2024-01-01 10:00:00');
        $entity->setCreateTime($createTime);

        $this->assertSame($createTime, $entity->getCreateTime());
    }

    public function testUpdateTimeGetterAndSetter(): void
    {
        $entity = new ScreenOperateRecord();
        $this->assertNull($entity->getUpdateTime());

        $updateTime = new \DateTimeImmutable('2024-01-01 11:00:00');
        $entity->setUpdateTime($updateTime);

        $this->assertSame($updateTime, $entity->getUpdateTime());
    }

    public function testEntityWithAllPropertiesSet(): void
    {
        $entity = new ScreenOperateRecord();
        $time = new \DateTimeImmutable('2024-01-01 12:00:00');
        $createTime = new \DateTimeImmutable('2024-01-01 10:00:00');
        $updateTime = new \DateTimeImmutable('2024-01-01 11:00:00');

        $entity->setTime($time);
        $entity->setUserid('user123');
        $entity->setDepartmentId(12345);
        $entity->setScreenShotType(ScreenShotTypeEnum::CHAT);
        $entity->setScreenShotContent('Screenshot content');
        $entity->setSystem('macOS');
        $entity->setCreateTime($createTime);
        $entity->setUpdateTime($updateTime);

        $this->assertSame($time, $entity->getTime());
        $this->assertSame('user123', $entity->getUserid());
        $this->assertSame(12345, $entity->getDepartmentId());
        $this->assertSame(ScreenShotTypeEnum::CHAT, $entity->getScreenShotType());
        $this->assertSame('Screenshot content', $entity->getScreenShotContent());
        $this->assertSame('macOS', $entity->getSystem());
        $this->assertSame($createTime, $entity->getCreateTime());
        $this->assertSame($updateTime, $entity->getUpdateTime());
    }
}
