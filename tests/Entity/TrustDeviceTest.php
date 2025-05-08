<?php

namespace WechatWorkSecurityBundle\Tests\Entity;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Entity\TrustDevice;
use WechatWorkSecurityBundle\Enum\TrustDeviceSourceEnum;
use WechatWorkSecurityBundle\Enum\TrustDeviceStatusEnum;

class TrustDeviceTest extends TestCase
{
    private TrustDevice $trustDevice;

    protected function setUp(): void
    {
        $this->trustDevice = new TrustDevice();
    }

    public function testDefaultValues_shouldBeCorrect(): void
    {
        $this->assertSame(0, $this->trustDevice->getId());
        $this->assertNull($this->trustDevice->getType());
        $this->assertNull($this->trustDevice->getDeviceCode());
        $this->assertNull($this->trustDevice->getSystem());
        $this->assertNull($this->trustDevice->getMacAddr());
        $this->assertNull($this->trustDevice->getMotherboardUuid());
        $this->assertNull($this->trustDevice->getHarddiskUuid());
        $this->assertNull($this->trustDevice->getDomain());
        $this->assertNull($this->trustDevice->getPcName());
        $this->assertNull($this->trustDevice->getSeqNo());
        $this->assertNull($this->trustDevice->getLastLoginTime());
        $this->assertNull($this->trustDevice->getLastLoginUserid());
        $this->assertNull($this->trustDevice->getConfirmTimestamp());
        $this->assertNull($this->trustDevice->getConfirmUserid());
        $this->assertNull($this->trustDevice->getApprovedUserid());
        $this->assertNull($this->trustDevice->getCreateTime());
        $this->assertNull($this->trustDevice->getUpdateTime());
    }

    public function testSetAndGetType_withValidValue_shouldReturnSameValue(): void
    {
        $type = 'testType';
        $this->trustDevice->setType($type);
        $this->assertSame($type, $this->trustDevice->getType());
    }

    public function testSetAndGetDeviceCode_withValidValue_shouldReturnSameValue(): void
    {
        $deviceCode = 'testDeviceCode';
        $this->trustDevice->setDeviceCode($deviceCode);
        $this->assertSame($deviceCode, $this->trustDevice->getDeviceCode());
    }

    public function testSetAndGetSystem_withValidValue_shouldReturnSameValue(): void
    {
        $system = 'testSystem';
        $this->trustDevice->setSystem($system);
        $this->assertSame($system, $this->trustDevice->getSystem());
    }

    public function testSetAndGetMacAddr_withValidValue_shouldReturnSameValue(): void
    {
        $macAddr = 'testMacAddr';
        $this->trustDevice->setMacAddr($macAddr);
        $this->assertSame($macAddr, $this->trustDevice->getMacAddr());
    }

    public function testSetAndGetMotherboardUuid_withValidValue_shouldReturnSameValue(): void
    {
        $motherboardUuid = 'testMotherboardUuid';
        $this->trustDevice->setMotherboardUuid($motherboardUuid);
        $this->assertSame($motherboardUuid, $this->trustDevice->getMotherboardUuid());
    }

    public function testSetAndGetHarddiskUuid_withValidValue_shouldReturnSameValue(): void
    {
        $harddiskUuid = 'testHarddiskUuid';
        $this->trustDevice->setHarddiskUuid($harddiskUuid);
        $this->assertSame($harddiskUuid, $this->trustDevice->getHarddiskUuid());
    }

    public function testSetAndGetDomain_withValidValue_shouldReturnSameValue(): void
    {
        $domain = 'testDomain';
        $this->trustDevice->setDomain($domain);
        $this->assertSame($domain, $this->trustDevice->getDomain());
    }

    public function testSetAndGetPcName_withValidValue_shouldReturnSameValue(): void
    {
        $pcName = 'testPcName';
        $this->trustDevice->setPcName($pcName);
        $this->assertSame($pcName, $this->trustDevice->getPcName());
    }

    public function testSetAndGetSeqNo_withValidValue_shouldReturnSameValue(): void
    {
        $seqNo = 'testSeqNo';
        $this->trustDevice->setSeqNo($seqNo);
        $this->assertSame($seqNo, $this->trustDevice->getSeqNo());
    }

    public function testSetAndGetLastLoginTime_withValidValue_shouldReturnSameValue(): void
    {
        $lastLoginTime = '1622548800';
        $this->trustDevice->setLastLoginTime($lastLoginTime);
        $this->assertSame($lastLoginTime, $this->trustDevice->getLastLoginTime());
    }

    public function testSetAndGetLastLoginUserid_withValidValue_shouldReturnSameValue(): void
    {
        $lastLoginUserid = 'user123';
        $this->trustDevice->setLastLoginUserid($lastLoginUserid);
        $this->assertSame($lastLoginUserid, $this->trustDevice->getLastLoginUserid());
    }

    public function testSetAndGetConfirmTimestamp_withValidValue_shouldReturnSameValue(): void
    {
        $confirmTimestamp = '1622548800';
        $this->trustDevice->setConfirmTimestamp($confirmTimestamp);
        $this->assertSame($confirmTimestamp, $this->trustDevice->getConfirmTimestamp());
    }

    public function testSetAndGetConfirmUserid_withValidValue_shouldReturnSameValue(): void
    {
        $confirmUserid = 'user123';
        $this->trustDevice->setConfirmUserid($confirmUserid);
        $this->assertSame($confirmUserid, $this->trustDevice->getConfirmUserid());
    }

    public function testSetAndGetApprovedUserid_withValidValue_shouldReturnSameValue(): void
    {
        $approvedUserid = 'user123';
        $this->trustDevice->setApprovedUserid($approvedUserid);
        $this->assertSame($approvedUserid, $this->trustDevice->getApprovedUserid());
    }

    public function testSetAndGetSource_withValidEnum_shouldReturnSameEnum(): void
    {
        $source = TrustDeviceSourceEnum::ADMIN_IMPORT;
        $this->trustDevice->setSource($source);
        $this->assertSame($source, $this->trustDevice->getSource());
    }

    public function testSetAndGetStatus_withValidEnum_shouldReturnSameEnum(): void
    {
        $status = TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE;
        $this->trustDevice->setStatus($status);
        $this->assertSame($status, $this->trustDevice->getStatus());
    }

    public function testSetAndGetCreateTime_withDateTimeObject_shouldReturnSameObject(): void
    {
        $createTime = new DateTimeImmutable();
        $this->trustDevice->setCreateTime($createTime);
        $this->assertSame($createTime, $this->trustDevice->getCreateTime());
    }

    public function testSetAndGetUpdateTime_withDateTimeObject_shouldReturnSameObject(): void
    {
        $updateTime = new DateTimeImmutable();
        $this->trustDevice->setUpdateTime($updateTime);
        $this->assertSame($updateTime, $this->trustDevice->getUpdateTime());
    }
}
