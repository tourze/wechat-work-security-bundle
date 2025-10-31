<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatWorkSecurityBundle\Entity\TrustDevice;
use WechatWorkSecurityBundle\Enum\TrustDeviceSourceEnum;
use WechatWorkSecurityBundle\Enum\TrustDeviceStatusEnum;
use WechatWorkSecurityBundle\Repository\TrustDeviceRepository;

/**
 * @template-extends AbstractRepositoryTestCase<TrustDevice>
 * @internal
 */
#[CoversClass(TrustDeviceRepository::class)]
#[RunTestsInSeparateProcesses]
final class TrustDeviceRepositoryTest extends AbstractRepositoryTestCase
{
    protected function onSetUp(): void
    {
        // 无需特殊设置
    }

    protected function createNewEntity(): object
    {
        $entity = new TrustDevice();
        $entity->setType('PC');
        $entity->setDeviceCode('DEVICE_' . uniqid());
        $entity->setSystem('Windows ' . random_int(7, 11));
        $entity->setMacAddr(sprintf('%02X:%02X:%02X:%02X:%02X:%02X',
            random_int(0, 255),
            random_int(0, 255),
            random_int(0, 255),
            random_int(0, 255),
            random_int(0, 255),
            random_int(0, 255)
        ));
        $entity->setMotherboardUuid(sprintf('%08x-%04x-%04x-%04x-%012x',
            random_int(0, 0xFFFFFFFF),
            random_int(0, 0xFFFF),
            random_int(0, 0xFFFF),
            random_int(0, 0xFFFF),
            random_int(0, 0xFFFFFFFFFFFF)
        ));
        $entity->setHarddiskUuid(sprintf('%08x-%04x-%04x-%04x-%012x',
            random_int(0, 0xFFFFFFFF),
            random_int(0, 0xFFFF),
            random_int(0, 0xFFFF),
            random_int(0, 0xFFFF),
            random_int(0, 0xFFFFFFFFFFFF)
        ));
        $entity->setDomain('DOMAIN_' . uniqid());
        $entity->setPcName('PC_' . uniqid());
        $entity->setSeqNo('SN_' . uniqid());
        $entity->setLastLoginTime(strval(time()));
        $entity->setLastLoginUserid('user_' . uniqid());
        $entity->setConfirmTimestamp(strval(time()));
        $entity->setConfirmUserid('confirm_' . uniqid());
        $entity->setApprovedUserid('approved_' . uniqid());
        $entity->setSource(TrustDeviceSourceEnum::ADMIN_IMPORT);
        $entity->setStatus(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE);

        return $entity;
    }

    protected function getRepository(): TrustDeviceRepository
    {
        $repository = self::getService(TrustDeviceRepository::class);
        $this->assertInstanceOf(TrustDeviceRepository::class, $repository);

        return $repository;
    }

    public function testSaveMethodPersistsEntity(): void
    {
        $entity = $this->createTestEntity();

        $this->getRepository()->save($entity);

        $this->assertGreaterThan(0, $entity->getId());

        $savedEntity = $this->getRepository()->find($entity->getId());
        $this->assertNotNull($savedEntity);
        $this->assertSame($entity->getDeviceCode(), $savedEntity->getDeviceCode());
        $this->assertSame($entity->getSystem(), $savedEntity->getSystem());
    }

    public function testRemoveMethodDeletesEntity(): void
    {
        $entity = $this->createTestEntity();
        $this->getRepository()->save($entity);
        $entityId = $entity->getId();

        $this->getRepository()->remove($entity);

        $deletedEntity = $this->getRepository()->find($entityId);
        $this->assertNull($deletedEntity);
    }

    public function testFindByWithCriteriaShouldReturnMatchingEntities(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setDeviceCode('device001');
        $entity2 = $this->createTestEntity();
        $entity2->setDeviceCode('device002');

        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['deviceCode' => 'device001']);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertSame('device001', $result[0]->getDeviceCode());
    }

    public function testFindOneByWithCriteriaShouldReturnSingleEntity(): void
    {
        $this->clearDatabase();
        $entity = $this->createTestEntity();
        $entity->setDeviceCode('uniquedevice');
        $this->getRepository()->save($entity);

        $result = $this->getRepository()->findOneBy(['deviceCode' => 'uniquedevice']);

        $this->assertNotNull($result);
        $this->assertInstanceOf(TrustDevice::class, $result);
        $this->assertSame('uniquedevice', $result->getDeviceCode());
    }

    public function testSaveWithoutFlushShouldNotPersistImmediately(): void
    {
        $entity = $this->createTestEntity();

        $this->getRepository()->save($entity, false);

        $this->assertSame(0, $entity->getId());
    }

    public function testRemoveWithoutFlushShouldNotDeleteImmediately(): void
    {
        $entity = $this->createTestEntity();
        $this->getRepository()->save($entity);
        $entityId = $entity->getId();

        $this->getRepository()->remove($entity, false);

        $foundEntity = $this->getRepository()->find($entityId);
        $this->assertNotNull($foundEntity);
    }

    public function testFindBySourceReturnsMatchingRecords(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setSource(TrustDeviceSourceEnum::ADMIN_IMPORT);
        $entity2 = $this->createTestEntity();
        $entity2->setSource(TrustDeviceSourceEnum::MEMBER_CONFIRMATION);

        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['source' => TrustDeviceSourceEnum::ADMIN_IMPORT]);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertSame(TrustDeviceSourceEnum::ADMIN_IMPORT, $result[0]->getSource());
    }

    public function testFindByStatusReturnsMatchingRecords(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setStatus(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE);
        $entity2 = $this->createTestEntity();
        $entity2->setStatus(TrustDeviceStatusEnum::PENDING_INVITATION);

        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['status' => TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE]);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertSame(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE, $result[0]->getStatus());
    }

    public function testFindByMacAddrReturnsMatchingRecords(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setMacAddr('AA:BB:CC:DD:EE:FF');
        $entity2 = $this->createTestEntity();
        $entity2->setMacAddr('11:22:33:44:55:66');

        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['macAddr' => 'AA:BB:CC:DD:EE:FF']);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertSame('AA:BB:CC:DD:EE:FF', $result[0]->getMacAddr());
    }

    public function testFindByLastLoginUseridReturnsMatchingRecords(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setLastLoginUserid('user123');
        $entity2 = $this->createTestEntity();
        $entity2->setLastLoginUserid('user456');

        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['lastLoginUserid' => 'user123']);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertSame('user123', $result[0]->getLastLoginUserid());
    }

    private function createTestEntity(): TrustDevice
    {
        $entity = new TrustDevice();
        $entity->setType('PC');
        $entity->setDeviceCode('DEVICE001');
        $entity->setSystem('Windows 10');
        $entity->setMacAddr('AA:BB:CC:DD:EE:FF');
        $entity->setMotherboardUuid('12345678-1234-1234-1234-123456789012');
        $entity->setHarddiskUuid('87654321-4321-4321-4321-210987654321');
        $entity->setDomain('COMPANY');
        $entity->setPcName('PC-001');
        $entity->setSeqNo('SN123456789');
        $entity->setLastLoginTime('1640995200');
        $entity->setLastLoginUserid('testuser');
        $entity->setConfirmTimestamp('1640995200');
        $entity->setConfirmUserid('admin');
        $entity->setApprovedUserid('manager');
        $entity->setSource(TrustDeviceSourceEnum::ADMIN_IMPORT);
        $entity->setStatus(TrustDeviceStatusEnum::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE);

        return $entity;
    }

    public function testFindOneByWithSortingReturnsFirstMatch(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setDeviceCode('sameCode');
        $entity1->setSystem('Windows');
        $entity2 = $this->createTestEntity();
        $entity2->setDeviceCode('sameCode');
        $entity2->setSystem('macOS');
        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findOneBy(['deviceCode' => 'sameCode'], ['system' => 'ASC']);

        $this->assertNotNull($result);
        $this->assertSame('Windows', $result->getSystem());
    }

    public function testFindByNullFieldsReturnsMatchingRecords(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setDomain(null);
        $entity2 = $this->createTestEntity();
        $entity2->setDomain('COMPANY');
        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['domain' => null]);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertNull($result[0]->getDomain());
    }

    public function testFindByNullApprovedUseridReturnsMatchingRecords(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setApprovedUserid(null);
        $entity2 = $this->createTestEntity();
        $entity2->setApprovedUserid('admin');
        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['approvedUserid' => null]);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertNull($result[0]->getApprovedUserid());
    }

    public function testFindByNullConfirmUseridReturnsMatchingRecords(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setConfirmUserid(null);
        $entity2 = $this->createTestEntity();
        $entity2->setConfirmUserid('user123');
        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['confirmUserid' => null]);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertNull($result[0]->getConfirmUserid());
    }

    public function testFindByNullLastLoginTimeReturnsMatchingRecords(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setLastLoginTime(null);
        $entity2 = $this->createTestEntity();
        $entity2->setLastLoginTime('1640995200');
        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['lastLoginTime' => null]);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertNull($result[0]->getLastLoginTime());
    }

    private function clearDatabase(): void
    {
        $entityManager = self::getService(EntityManagerInterface::class);
        $entityManager->createQuery('DELETE FROM ' . TrustDevice::class)->execute();
    }
}
