<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatWorkSecurityBundle\Entity\MemberOperateRecord;
use WechatWorkSecurityBundle\Repository\MemberOperateRecordRepository;

/**
 * @template-extends AbstractRepositoryTestCase<MemberOperateRecord>
 * @internal
 */
#[CoversClass(MemberOperateRecordRepository::class)]
#[RunTestsInSeparateProcesses]
final class MemberOperateRecordRepositoryTest extends AbstractRepositoryTestCase
{
    protected function onSetUp(): void
    {
        // 无需特殊设置
    }

    protected function createNewEntity(): object
    {
        $entity = new MemberOperateRecord();
        $entity->setTime(new \DateTimeImmutable());
        $entity->setUserid('testuser_' . uniqid());
        $entity->setOperType('test_operation');
        $entity->setDetailInfo('Test operation detail');
        $entity->setIp('192.168.' . random_int(1, 255) . '.' . random_int(1, 255));

        return $entity;
    }

    protected function getRepository(): MemberOperateRecordRepository
    {
        $repository = self::getService(MemberOperateRecordRepository::class);
        $this->assertInstanceOf(MemberOperateRecordRepository::class, $repository);

        return $repository;
    }

    public function testSaveMethodPersistsEntity(): void
    {
        $entity = $this->createTestEntity();

        $this->getRepository()->save($entity);

        $this->assertGreaterThan(0, $entity->getId());

        $savedEntity = $this->getRepository()->find($entity->getId());
        $this->assertNotNull($savedEntity);
        $this->assertSame($entity->getUserid(), $savedEntity->getUserid());
        $this->assertSame($entity->getOperType(), $savedEntity->getOperType());
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
        $entity1->setUserid('testuser1');
        $entity2 = $this->createTestEntity();
        $entity2->setUserid('testuser2');

        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['userid' => 'testuser1']);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertSame('testuser1', $result[0]->getUserid());
    }

    public function testFindOneByWithCriteriaShouldReturnSingleEntity(): void
    {
        $this->clearDatabase();
        $entity = $this->createTestEntity();
        $entity->setUserid('uniqueuser');
        $this->getRepository()->save($entity);

        $result = $this->getRepository()->findOneBy(['userid' => 'uniqueuser']);

        $this->assertNotNull($result);
        $this->assertInstanceOf(MemberOperateRecord::class, $result);
        $this->assertSame('uniqueuser', $result->getUserid());
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

    public function testFindByOperTypeReturnsMatchingRecords(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setOperType('login');
        $entity2 = $this->createTestEntity();
        $entity2->setOperType('logout');

        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['operType' => 'login']);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertSame('login', $result[0]->getOperType());
    }

    public function testFindByIpReturnsMatchingRecords(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setIp('192.168.1.1');
        $entity2 = $this->createTestEntity();
        $entity2->setIp('192.168.1.2');

        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['ip' => '192.168.1.1']);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertSame('192.168.1.1', $result[0]->getIp());
    }

    private function createTestEntity(): MemberOperateRecord
    {
        $entity = new MemberOperateRecord();
        $entity->setTime(new \DateTimeImmutable());
        $entity->setUserid('testuser');
        $entity->setOperType('login');
        $entity->setDetailInfo('用户登录系统');
        $entity->setIp('192.168.1.100');

        return $entity;
    }

    public function testFindOneByWithSortingReturnsFirstMatch(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setUserid('sameUser');
        $entity1->setOperType('login');
        $entity2 = $this->createTestEntity();
        $entity2->setUserid('sameUser');
        $entity2->setOperType('logout');
        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findOneBy(['userid' => 'sameUser'], ['operType' => 'ASC']);

        $this->assertNotNull($result);
        $this->assertSame('login', $result->getOperType());
    }

    private function clearDatabase(): void
    {
        $entityManager = self::getService(EntityManagerInterface::class);
        $entityManager->createQuery('DELETE FROM ' . MemberOperateRecord::class)->execute();
    }
}
