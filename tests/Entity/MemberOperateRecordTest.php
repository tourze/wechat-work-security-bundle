<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatWorkSecurityBundle\Entity\MemberOperateRecord;

/**
 * @internal
 */
#[CoversClass(MemberOperateRecord::class)]
final class MemberOperateRecordTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new MemberOperateRecord();
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'userid' => ['userid', 'test_user_123'],
            'operType' => ['operType', 'login'],
            'ip' => ['ip', '192.168.1.100'],
        ];
    }

    public function testGetIdReturnsZeroByDefault(): void
    {
        $entity = new MemberOperateRecord();
        $this->assertSame(0, $entity->getId());
    }

    public function testTimeGetterAndSetter(): void
    {
        $entity = new MemberOperateRecord();
        $this->assertNull($entity->getTime());

        $time = new \DateTime('2024-01-01 12:00:00');
        $entity->setTime($time);

        $this->assertSame($time, $entity->getTime());
    }

    public function testTimeSetterWithNull(): void
    {
        $entity = new MemberOperateRecord();
        $entity->setTime(null);
        $this->assertNull($entity->getTime());
    }

    public function testUseridGetterAndSetter(): void
    {
        $entity = new MemberOperateRecord();
        $this->assertNull($entity->getUserid());

        $userid = 'test_user_123';
        $entity->setUserid($userid);

        $this->assertSame($userid, $entity->getUserid());
    }

    public function testUseridSetterWithNull(): void
    {
        $entity = new MemberOperateRecord();
        $entity->setUserid(null);
        $this->assertNull($entity->getUserid());
    }

    public function testOperTypeGetterAndSetter(): void
    {
        $entity = new MemberOperateRecord();
        $this->assertNull($entity->getOperType());

        $operType = 'login';
        $entity->setOperType($operType);

        $this->assertSame($operType, $entity->getOperType());
    }

    public function testOperTypeSetterWithNull(): void
    {
        $entity = new MemberOperateRecord();
        $entity->setOperType(null);
        $this->assertNull($entity->getOperType());
    }

    public function testDetailInfoGetterAndSetter(): void
    {
        $entity = new MemberOperateRecord();
        $this->assertNull($entity->getDetailInfo());

        $detailInfo = 'User logged in from mobile';
        $entity->setDetailInfo($detailInfo);

        $this->assertSame($detailInfo, $entity->getDetailInfo());
    }

    public function testDetailInfoSetterWithNull(): void
    {
        $entity = new MemberOperateRecord();
        $entity->setDetailInfo(null);
        $this->assertNull($entity->getDetailInfo());
    }

    public function testIpGetterAndSetter(): void
    {
        $entity = new MemberOperateRecord();
        $this->assertNull($entity->getIp());

        $ip = '192.168.1.100';
        $entity->setIp($ip);

        $this->assertSame($ip, $entity->getIp());
    }

    public function testIpSetterWithNull(): void
    {
        $entity = new MemberOperateRecord();
        $entity->setIp(null);
        $this->assertNull($entity->getIp());
    }

    public function testCreateTimeGetterAndSetter(): void
    {
        $entity = new MemberOperateRecord();
        $this->assertNull($entity->getCreateTime());

        $createTime = new \DateTimeImmutable('2024-01-01 10:00:00');
        $entity->setCreateTime($createTime);

        $this->assertSame($createTime, $entity->getCreateTime());
    }

    public function testCreateTimeSetterWithNull(): void
    {
        $entity = new MemberOperateRecord();
        $entity->setCreateTime(null);
        $this->assertNull($entity->getCreateTime());
    }

    public function testUpdateTimeGetterAndSetter(): void
    {
        $entity = new MemberOperateRecord();
        $this->assertNull($entity->getUpdateTime());

        $updateTime = new \DateTimeImmutable('2024-01-01 11:00:00');
        $entity->setUpdateTime($updateTime);

        $this->assertSame($updateTime, $entity->getUpdateTime());
    }

    public function testUpdateTimeSetterWithNull(): void
    {
        $entity = new MemberOperateRecord();
        $entity->setUpdateTime(null);
        $this->assertNull($entity->getUpdateTime());
    }

    public function testEntityWithAllPropertiesSet(): void
    {
        $entity = new MemberOperateRecord();
        $time = new \DateTimeImmutable('2024-01-01 12:00:00');
        $createTime = new \DateTimeImmutable('2024-01-01 10:00:00');
        $updateTime = new \DateTimeImmutable('2024-01-01 11:00:00');

        $entity->setTime($time);
        $entity->setUserid('user123');
        $entity->setOperType('login');
        $entity->setDetailInfo('User logged in from mobile');
        $entity->setIp('192.168.1.100');
        $entity->setCreateTime($createTime);
        $entity->setUpdateTime($updateTime);

        $this->assertSame($time, $entity->getTime());
        $this->assertSame('user123', $entity->getUserid());
        $this->assertSame('login', $entity->getOperType());
        $this->assertSame('User logged in from mobile', $entity->getDetailInfo());
        $this->assertSame('192.168.1.100', $entity->getIp());
        $this->assertSame($createTime, $entity->getCreateTime());
        $this->assertSame($updateTime, $entity->getUpdateTime());
    }

    public function testIpWithIpv6Address(): void
    {
        $entity = new MemberOperateRecord();
        $ipv6 = '2001:db8::1';
        $entity->setIp($ipv6);

        $this->assertSame($ipv6, $entity->getIp());
    }

    public function testOperTypeWithDifferentOperations(): void
    {
        $entity = new MemberOperateRecord();
        $operations = ['login', 'logout', 'download', 'upload', 'delete'];

        foreach ($operations as $operation) {
            $entity->setOperType($operation);
            $this->assertSame($operation, $entity->getOperType());
        }
    }
}
