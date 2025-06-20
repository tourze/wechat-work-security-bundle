<?php

namespace WechatWorkSecurityBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Entity\TrustDevice;
use WechatWorkSecurityBundle\Enum\TrustDeviceSourceEnum;
use WechatWorkSecurityBundle\Enum\TrustDeviceStatusEnum;

class TrustDeviceTest extends TestCase
{
    private TrustDevice $entity;

    protected function setUp(): void
    {
        $this->entity = new TrustDevice();
    }

    public function test_getId_returns_zero_by_default(): void
    {
        $this->assertSame(0, $this->entity->getId());
    }

    public function test_type_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getType());

        $type = '1';
        $this->entity->setType($type);

        $this->assertSame($type, $this->entity->getType());
    }

    public function test_type_setter_with_null(): void
    {
        $this->entity->setType(null);
        $this->assertNull($this->entity->getType());
    }

    public function test_deviceCode_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getDeviceCode());

        $deviceCode = 'device_001';
        $this->entity->setDeviceCode($deviceCode);

        $this->assertSame($deviceCode, $this->entity->getDeviceCode());
    }

    public function test_deviceCode_setter_with_null(): void
    {
        $this->entity->setDeviceCode(null);
        $this->assertNull($this->entity->getDeviceCode());
    }

    public function test_system_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getSystem());

        $system = 'Windows 11';
        $this->entity->setSystem($system);

        $this->assertSame($system, $this->entity->getSystem());
    }

    public function test_system_setter_with_null(): void
    {
        $this->entity->setSystem(null);
        $this->assertNull($this->entity->getSystem());
    }

    public function test_macAddr_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getMacAddr());

        $macAddr = '00:11:22:33:44:55';
        $this->entity->setMacAddr($macAddr);

        $this->assertSame($macAddr, $this->entity->getMacAddr());
    }

    public function test_macAddr_setter_with_null(): void
    {
        $this->entity->setMacAddr(null);
        $this->assertNull($this->entity->getMacAddr());
    }

    public function test_motherboardUuid_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getMotherboardUuid());

        $uuid = '12345678-1234-1234-1234-123456789abc';
        $this->entity->setMotherboardUuid($uuid);

        $this->assertSame($uuid, $this->entity->getMotherboardUuid());
    }

    public function test_motherboardUuid_setter_with_null(): void
    {
        $this->entity->setMotherboardUuid(null);
        $this->assertNull($this->entity->getMotherboardUuid());
    }

    public function test_harddiskUuid_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getHarddiskUuid());

        $uuid = '87654321-4321-4321-4321-cba987654321';
        $this->entity->setHarddiskUuid($uuid);

        $this->assertSame($uuid, $this->entity->getHarddiskUuid());
    }

    public function test_harddiskUuid_setter_with_null(): void
    {
        $this->entity->setHarddiskUuid(null);
        $this->assertNull($this->entity->getHarddiskUuid());
    }

    public function test_domain_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getDomain());

        $domain = 'company.local';
        $this->entity->setDomain($domain);

        $this->assertSame($domain, $this->entity->getDomain());
    }

    public function test_domain_setter_with_null(): void
    {
        $this->entity->setDomain(null);
        $this->assertNull($this->entity->getDomain());
    }

    public function test_pcName_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getPcName());

        $pcName = 'DESKTOP-ABCD123';
        $this->entity->setPcName($pcName);

        $this->assertSame($pcName, $this->entity->getPcName());
    }

    public function test_pcName_setter_with_null(): void
    {
        $this->entity->setPcName(null);
        $this->assertNull($this->entity->getPcName());
    }

    public function test_seqNo_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getSeqNo());

        $seqNo = 'C02XY1234567';
        $this->entity->setSeqNo($seqNo);

        $this->assertSame($seqNo, $this->entity->getSeqNo());
    }

    public function test_seqNo_setter_with_null(): void
    {
        $this->entity->setSeqNo(null);
        $this->assertNull($this->entity->getSeqNo());
    }

    public function test_lastLoginTime_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getLastLoginTime());

        $timestamp = '1640995200';
        $this->entity->setLastLoginTime($timestamp);

        $this->assertSame($timestamp, $this->entity->getLastLoginTime());
    }

    public function test_lastLoginTime_setter_with_null(): void
    {
        $this->entity->setLastLoginTime(null);
        $this->assertNull($this->entity->getLastLoginTime());
    }

    public function test_lastLoginUserid_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getLastLoginUserid());

        $userid = 'user123';
        $this->entity->setLastLoginUserid($userid);

        $this->assertSame($userid, $this->entity->getLastLoginUserid());
    }

    public function test_lastLoginUserid_setter_with_null(): void
    {
        $this->entity->setLastLoginUserid(null);
        $this->assertNull($this->entity->getLastLoginUserid());
    }

    public function test_confirmTimestamp_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getConfirmTimestamp());

        $timestamp = '1640995200';
        $this->entity->setConfirmTimestamp($timestamp);

        $this->assertSame($timestamp, $this->entity->getConfirmTimestamp());
    }

    public function test_confirmTimestamp_setter_with_null(): void
    {
        $this->entity->setConfirmTimestamp(null);
        $this->assertNull($this->entity->getConfirmTimestamp());
    }

    public function test_confirmUserid_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getConfirmUserid());

        $userid = 'admin123';
        $this->entity->setConfirmUserid($userid);

        $this->assertSame($userid, $this->entity->getConfirmUserid());
    }

    public function test_confirmUserid_setter_with_null(): void
    {
        $this->entity->setConfirmUserid(null);
        $this->assertNull($this->entity->getConfirmUserid());
    }

    public function test_approvedUserid_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getApprovedUserid());

        $userid = 'admin456';
        $this->entity->setApprovedUserid($userid);

        $this->assertSame($userid, $this->entity->getApprovedUserid());
    }

    public function test_approvedUserid_setter_with_null(): void
    {
        $this->entity->setApprovedUserid(null);
        $this->assertNull($this->entity->getApprovedUserid());
    }

    public function test_createTime_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getCreateTime());

        $createTime = new \DateTimeImmutable('2024-01-01 10:00:00');
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

        $updateTime = new \DateTimeImmutable('2024-01-01 11:00:00');
        $this->entity->setUpdateTime($updateTime);

        $this->assertSame($updateTime, $this->entity->getUpdateTime());
    }

    public function test_updateTime_setter_with_null(): void
    {
        $this->entity->setUpdateTime(null);
        $this->assertNull($this->entity->getUpdateTime());
    }

    public function test_source_getter_and_setter(): void
    {
        $this->assertSame(TrustDeviceSourceEnum::UNKNOWN, $this->entity->getSource());

        $source = TrustDeviceSourceEnum::ADMIN_IMPORT;
        $this->entity->setSource($source);

        $this->assertSame($source, $this->entity->getSource());
    }

    public function test_source_setter_with_null(): void
    {
        $this->entity->setSource(null);
        $this->assertNull($this->entity->getSource());
    }

    public function test_source_has_default_value(): void
    {
        $freshEntity = new TrustDevice();
        $this->assertSame(TrustDeviceSourceEnum::UNKNOWN, $freshEntity->getSource());
    }

    public function test_status_getter_and_setter(): void
    {
        $this->assertSame(TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN, $this->entity->getStatus());

        $status = TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE;
        $this->entity->setStatus($status);

        $this->assertSame($status, $this->entity->getStatus());
    }

    public function test_status_setter_with_null(): void
    {
        $this->entity->setStatus(null);
        $this->assertNull($this->entity->getStatus());
    }

    public function test_status_has_default_value(): void
    {
        $freshEntity = new TrustDevice();
        $this->assertSame(TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN, $freshEntity->getStatus());
    }

    public function test_entity_with_all_properties_set(): void
    {
        $createTime = new \DateTimeImmutable('2024-01-01 10:00:00');
        $updateTime = new \DateTimeImmutable('2024-01-01 11:00:00');

        $this->entity->setType('1');
        $this->entity->setDeviceCode('device001');
        $this->entity->setSystem('Windows 11');
        $this->entity->setMacAddr('00:11:22:33:44:55');
        $this->entity->setMotherboardUuid('12345678-1234-1234-1234-123456789abc');
        $this->entity->setHarddiskUuid('87654321-4321-4321-4321-cba987654321');
        $this->entity->setDomain('company.local');
        $this->entity->setPcName('DESKTOP-ABCD123');
        $this->entity->setSeqNo('C02XY1234567');
        $this->entity->setLastLoginTime('1640995200');
        $this->entity->setLastLoginUserid('user123');
        $this->entity->setConfirmTimestamp('1640995200');
        $this->entity->setConfirmUserid('admin123');
        $this->entity->setApprovedUserid('admin456');
        $this->entity->setSource(TrustDeviceSourceEnum::ADMIN_IMPORT);
        $this->entity->setStatus(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE);
        $this->entity->setCreateTime($createTime);
        $this->entity->setUpdateTime($updateTime);

        $this->assertSame('1', $this->entity->getType());
        $this->assertSame('device001', $this->entity->getDeviceCode());
        $this->assertSame('Windows 11', $this->entity->getSystem());
        $this->assertSame('00:11:22:33:44:55', $this->entity->getMacAddr());
        $this->assertSame('12345678-1234-1234-1234-123456789abc', $this->entity->getMotherboardUuid());
        $this->assertSame('87654321-4321-4321-4321-cba987654321', $this->entity->getHarddiskUuid());
        $this->assertSame('company.local', $this->entity->getDomain());
        $this->assertSame('DESKTOP-ABCD123', $this->entity->getPcName());
        $this->assertSame('C02XY1234567', $this->entity->getSeqNo());
        $this->assertSame('1640995200', $this->entity->getLastLoginTime());
        $this->assertSame('user123', $this->entity->getLastLoginUserid());
        $this->assertSame('1640995200', $this->entity->getConfirmTimestamp());
        $this->assertSame('admin123', $this->entity->getConfirmUserid());
        $this->assertSame('admin456', $this->entity->getApprovedUserid());
        $this->assertSame(TrustDeviceSourceEnum::ADMIN_IMPORT, $this->entity->getSource());
        $this->assertSame(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE, $this->entity->getStatus());
        $this->assertSame($createTime, $this->entity->getCreateTime());
        $this->assertSame($updateTime, $this->entity->getUpdateTime());
    }

    public function test_macAddr_with_different_formats(): void
    {
        $formats = [
            '00:11:22:33:44:55',
            '00-11-22-33-44-55',
            '0011.2233.4455'
        ];

        foreach ($formats as $format) {
            $this->entity->setMacAddr($format);
            $this->assertSame($format, $this->entity->getMacAddr());
        }
    }

    public function test_type_with_different_device_types(): void
    {
        $types = ['1', '2', '3'];

        foreach ($types as $type) {
            $this->entity->setType($type);
            $this->assertSame($type, $this->entity->getType());
        }
    }
}
