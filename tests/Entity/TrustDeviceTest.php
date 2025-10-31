<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatWorkSecurityBundle\Entity\TrustDevice;
use WechatWorkSecurityBundle\Enum\TrustDeviceSourceEnum;
use WechatWorkSecurityBundle\Enum\TrustDeviceStatusEnum;

/**
 * @internal
 */
#[CoversClass(TrustDevice::class)]
final class TrustDeviceTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new TrustDevice();
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'type' => ['type', '1'],
            'deviceCode' => ['deviceCode', 'device_001'],
            'system' => ['system', 'Windows 11'],
        ];
    }

    public function testGetIdReturnsZeroByDefault(): void
    {
        $entity = new TrustDevice();
        $this->assertSame(0, $entity->getId());
    }

    private function createTestEntity(): TrustDevice
    {
        return new TrustDevice();
    }

    public function testTypeGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getType());

        $type = '1';
        $entity->setType($type);

        $this->assertSame($type, $entity->getType());
    }

    public function testTypeSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setType(null);
        $this->assertNull($entity->getType());
    }

    public function testDeviceCodeGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getDeviceCode());

        $deviceCode = 'device_001';
        $entity->setDeviceCode($deviceCode);

        $this->assertSame($deviceCode, $entity->getDeviceCode());
    }

    public function testDeviceCodeSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setDeviceCode(null);
        $this->assertNull($entity->getDeviceCode());
    }

    public function testSystemGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getSystem());

        $system = 'Windows 11';
        $entity->setSystem($system);

        $this->assertSame($system, $entity->getSystem());
    }

    public function testSystemSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setSystem(null);
        $this->assertNull($entity->getSystem());
    }

    public function testMacAddrGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getMacAddr());

        $macAddr = '00:11:22:33:44:55';
        $entity->setMacAddr($macAddr);

        $this->assertSame($macAddr, $entity->getMacAddr());
    }

    public function testMacAddrSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setMacAddr(null);
        $this->assertNull($entity->getMacAddr());
    }

    public function testMotherboardUuidGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getMotherboardUuid());

        $uuid = '12345678-1234-1234-1234-123456789abc';
        $entity->setMotherboardUuid($uuid);

        $this->assertSame($uuid, $entity->getMotherboardUuid());
    }

    public function testMotherboardUuidSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setMotherboardUuid(null);
        $this->assertNull($entity->getMotherboardUuid());
    }

    public function testHarddiskUuidGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getHarddiskUuid());

        $uuid = '87654321-4321-4321-4321-cba987654321';
        $entity->setHarddiskUuid($uuid);

        $this->assertSame($uuid, $entity->getHarddiskUuid());
    }

    public function testHarddiskUuidSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setHarddiskUuid(null);
        $this->assertNull($entity->getHarddiskUuid());
    }

    public function testDomainGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getDomain());

        $domain = 'company.local';
        $entity->setDomain($domain);

        $this->assertSame($domain, $entity->getDomain());
    }

    public function testDomainSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setDomain(null);
        $this->assertNull($entity->getDomain());
    }

    public function testPcNameGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getPcName());

        $pcName = 'DESKTOP-ABCD123';
        $entity->setPcName($pcName);

        $this->assertSame($pcName, $entity->getPcName());
    }

    public function testPcNameSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setPcName(null);
        $this->assertNull($entity->getPcName());
    }

    public function testSeqNoGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getSeqNo());

        $seqNo = 'C02XY1234567';
        $entity->setSeqNo($seqNo);

        $this->assertSame($seqNo, $entity->getSeqNo());
    }

    public function testSeqNoSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setSeqNo(null);
        $this->assertNull($entity->getSeqNo());
    }

    public function testLastLoginTimeGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getLastLoginTime());

        $timestamp = '1640995200';
        $entity->setLastLoginTime($timestamp);

        $this->assertSame($timestamp, $entity->getLastLoginTime());
    }

    public function testLastLoginTimeSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setLastLoginTime(null);
        $this->assertNull($entity->getLastLoginTime());
    }

    public function testLastLoginUseridGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getLastLoginUserid());

        $userid = 'user123';
        $entity->setLastLoginUserid($userid);

        $this->assertSame($userid, $entity->getLastLoginUserid());
    }

    public function testLastLoginUseridSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setLastLoginUserid(null);
        $this->assertNull($entity->getLastLoginUserid());
    }

    public function testConfirmTimestampGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getConfirmTimestamp());

        $timestamp = '1640995200';
        $entity->setConfirmTimestamp($timestamp);

        $this->assertSame($timestamp, $entity->getConfirmTimestamp());
    }

    public function testConfirmTimestampSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setConfirmTimestamp(null);
        $this->assertNull($entity->getConfirmTimestamp());
    }

    public function testConfirmUseridGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getConfirmUserid());

        $userid = 'admin123';
        $entity->setConfirmUserid($userid);

        $this->assertSame($userid, $entity->getConfirmUserid());
    }

    public function testConfirmUseridSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setConfirmUserid(null);
        $this->assertNull($entity->getConfirmUserid());
    }

    public function testApprovedUseridGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getApprovedUserid());

        $userid = 'admin456';
        $entity->setApprovedUserid($userid);

        $this->assertSame($userid, $entity->getApprovedUserid());
    }

    public function testApprovedUseridSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setApprovedUserid(null);
        $this->assertNull($entity->getApprovedUserid());
    }

    public function testCreateTimeGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getCreateTime());

        $createTime = new \DateTimeImmutable('2024-01-01 10:00:00');
        $entity->setCreateTime($createTime);

        $this->assertSame($createTime, $entity->getCreateTime());
    }

    public function testCreateTimeSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setCreateTime(null);
        $this->assertNull($entity->getCreateTime());
    }

    public function testUpdateTimeGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertNull($entity->getUpdateTime());

        $updateTime = new \DateTimeImmutable('2024-01-01 11:00:00');
        $entity->setUpdateTime($updateTime);

        $this->assertSame($updateTime, $entity->getUpdateTime());
    }

    public function testUpdateTimeSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setUpdateTime(null);
        $this->assertNull($entity->getUpdateTime());
    }

    public function testSourceGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertSame(TrustDeviceSourceEnum::UNKNOWN, $entity->getSource());

        $source = TrustDeviceSourceEnum::ADMIN_IMPORT;
        $entity->setSource($source);

        $this->assertSame($source, $entity->getSource());
    }

    public function testSourceSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setSource(null);
        $this->assertNull($entity->getSource());
    }

    public function testSourceHasDefaultValue(): void
    {
        $freshEntity = new TrustDevice();
        $this->assertSame(TrustDeviceSourceEnum::UNKNOWN, $freshEntity->getSource());
    }

    public function testStatusGetterAndSetter(): void
    {
        $entity = $this->createTestEntity();
        $this->assertSame(TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN, $entity->getStatus());

        $status = TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE;
        $entity->setStatus($status);

        $this->assertSame($status, $entity->getStatus());
    }

    public function testStatusSetterWithNull(): void
    {
        $entity = $this->createTestEntity();
        $entity->setStatus(null);
        $this->assertNull($entity->getStatus());
    }

    public function testStatusHasDefaultValue(): void
    {
        $freshEntity = new TrustDevice();
        $this->assertSame(TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN, $freshEntity->getStatus());
    }

    public function testEntityWithAllPropertiesSet(): void
    {
        $entity = $this->createTestEntity();
        $createTime = new \DateTimeImmutable('2024-01-01 10:00:00');
        $updateTime = new \DateTimeImmutable('2024-01-01 11:00:00');

        $entity->setType('1');
        $entity->setDeviceCode('device001');
        $entity->setSystem('Windows 11');
        $entity->setMacAddr('00:11:22:33:44:55');
        $entity->setMotherboardUuid('12345678-1234-1234-1234-123456789abc');
        $entity->setHarddiskUuid('87654321-4321-4321-4321-cba987654321');
        $entity->setDomain('company.local');
        $entity->setPcName('DESKTOP-ABCD123');
        $entity->setSeqNo('C02XY1234567');
        $entity->setLastLoginTime('1640995200');
        $entity->setLastLoginUserid('user123');
        $entity->setConfirmTimestamp('1640995200');
        $entity->setConfirmUserid('admin123');
        $entity->setApprovedUserid('admin456');
        $entity->setSource(TrustDeviceSourceEnum::ADMIN_IMPORT);
        $entity->setStatus(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE);
        $entity->setCreateTime($createTime);
        $entity->setUpdateTime($updateTime);

        $this->assertSame('1', $entity->getType());
        $this->assertSame('device001', $entity->getDeviceCode());
        $this->assertSame('Windows 11', $entity->getSystem());
        $this->assertSame('00:11:22:33:44:55', $entity->getMacAddr());
        $this->assertSame('12345678-1234-1234-1234-123456789abc', $entity->getMotherboardUuid());
        $this->assertSame('87654321-4321-4321-4321-cba987654321', $entity->getHarddiskUuid());
        $this->assertSame('company.local', $entity->getDomain());
        $this->assertSame('DESKTOP-ABCD123', $entity->getPcName());
        $this->assertSame('C02XY1234567', $entity->getSeqNo());
        $this->assertSame('1640995200', $entity->getLastLoginTime());
        $this->assertSame('user123', $entity->getLastLoginUserid());
        $this->assertSame('1640995200', $entity->getConfirmTimestamp());
        $this->assertSame('admin123', $entity->getConfirmUserid());
        $this->assertSame('admin456', $entity->getApprovedUserid());
        $this->assertSame(TrustDeviceSourceEnum::ADMIN_IMPORT, $entity->getSource());
        $this->assertSame(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE, $entity->getStatus());
        $this->assertSame($createTime, $entity->getCreateTime());
        $this->assertSame($updateTime, $entity->getUpdateTime());
    }

    public function testMacAddrWithDifferentFormats(): void
    {
        $entity = $this->createTestEntity();
        $formats = [
            '00:11:22:33:44:55',
            '00-11-22-33-44-55',
            '0011.2233.4455',
        ];

        foreach ($formats as $format) {
            $entity->setMacAddr($format);
            $this->assertSame($format, $entity->getMacAddr());
        }
    }

    public function testTypeWithDifferentDeviceTypes(): void
    {
        $entity = $this->createTestEntity();
        $types = ['1', '2', '3'];

        foreach ($types as $type) {
            $entity->setType($type);
            $this->assertSame($type, $entity->getType());
        }
    }
}
