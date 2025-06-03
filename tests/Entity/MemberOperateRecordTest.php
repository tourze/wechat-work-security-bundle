<?php

namespace WechatWorkSecurityBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Entity\MemberOperateRecord;

class MemberOperateRecordTest extends TestCase
{
    private MemberOperateRecord $entity;

    protected function setUp(): void
    {
        $this->entity = new MemberOperateRecord();
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

    public function test_time_setter_with_null(): void
    {
        $this->entity->setTime(null);
        $this->assertNull($this->entity->getTime());
    }

    public function test_userid_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getUserid());

        $userid = 'test_user_123';
        $this->entity->setUserid($userid);
        
        $this->assertSame($userid, $this->entity->getUserid());
    }

    public function test_userid_setter_with_null(): void
    {
        $this->entity->setUserid(null);
        $this->assertNull($this->entity->getUserid());
    }

    public function test_operType_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getOperType());

        $operType = 'login';
        $this->entity->setOperType($operType);
        
        $this->assertSame($operType, $this->entity->getOperType());
    }

    public function test_operType_setter_with_null(): void
    {
        $this->entity->setOperType(null);
        $this->assertNull($this->entity->getOperType());
    }

    public function test_detailInfo_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getDetailInfo());

        $detailInfo = 'User logged in from mobile';
        $this->entity->setDetailInfo($detailInfo);
        
        $this->assertSame($detailInfo, $this->entity->getDetailInfo());
    }

    public function test_detailInfo_setter_with_null(): void
    {
        $this->entity->setDetailInfo(null);
        $this->assertNull($this->entity->getDetailInfo());
    }

    public function test_ip_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getIp());

        $ip = '192.168.1.100';
        $this->entity->setIp($ip);
        
        $this->assertSame($ip, $this->entity->getIp());
    }

    public function test_ip_setter_with_null(): void
    {
        $this->entity->setIp(null);
        $this->assertNull($this->entity->getIp());
    }

    public function test_createTime_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getCreateTime());

        $createTime = new \DateTime('2024-01-01 10:00:00');
        $this->entity->setCreateTime($createTime);
        
        $this->assertSame($createTime, $this->entity->getCreateTime());
    }

    public function test_createTime_setter_with_null(): void
    {
        $this->entity->setCreateTime(null);
        $this->assertNull($this->entity->getCreateTime());
    }

    public function test_updateTime_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getUpdateTime());

        $updateTime = new \DateTime('2024-01-01 11:00:00');
        $this->entity->setUpdateTime($updateTime);
        
        $this->assertSame($updateTime, $this->entity->getUpdateTime());
    }

    public function test_updateTime_setter_with_null(): void
    {
        $this->entity->setUpdateTime(null);
        $this->assertNull($this->entity->getUpdateTime());
    }

    public function test_entity_with_all_properties_set(): void
    {
        $time = new \DateTime('2024-01-01 12:00:00');
        $createTime = new \DateTime('2024-01-01 10:00:00');
        $updateTime = new \DateTime('2024-01-01 11:00:00');
        
        $this->entity->setTime($time);
        $this->entity->setUserid('user123');
        $this->entity->setOperType('login');
        $this->entity->setDetailInfo('User logged in from mobile');
        $this->entity->setIp('192.168.1.100');
        $this->entity->setCreateTime($createTime);
        $this->entity->setUpdateTime($updateTime);

        $this->assertSame($time, $this->entity->getTime());
        $this->assertSame('user123', $this->entity->getUserid());
        $this->assertSame('login', $this->entity->getOperType());
        $this->assertSame('User logged in from mobile', $this->entity->getDetailInfo());
        $this->assertSame('192.168.1.100', $this->entity->getIp());
        $this->assertSame($createTime, $this->entity->getCreateTime());
        $this->assertSame($updateTime, $this->entity->getUpdateTime());
    }

    public function test_ip_with_ipv6_address(): void
    {
        $ipv6 = '2001:db8::1';
        $this->entity->setIp($ipv6);
        
        $this->assertSame($ipv6, $this->entity->getIp());
    }

    public function test_operType_with_different_operations(): void
    {
        $operations = ['login', 'logout', 'download', 'upload', 'delete'];
        
        foreach ($operations as $operation) {
            $this->entity->setOperType($operation);
            $this->assertSame($operation, $this->entity->getOperType());
        }
    }
} 