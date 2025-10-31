<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatWorkSecurityBundle\Entity\ScreenOperateRecord;
use WechatWorkSecurityBundle\Enum\ScreenShotTypeEnum;
use WechatWorkSecurityBundle\Repository\ScreenOperateRecordRepository;

/**
 * @template-extends AbstractRepositoryTestCase<ScreenOperateRecord>
 * @internal
 */
#[CoversClass(ScreenOperateRecordRepository::class)]
#[RunTestsInSeparateProcesses]
final class ScreenOperateRecordRepositoryTest extends AbstractRepositoryTestCase
{
    protected function onSetUp(): void
    {
        // 无需特殊设置
    }

    protected function createNewEntity(): object
    {
        $entity = new ScreenOperateRecord();
        $entity->setTime(new \DateTimeImmutable());
        $entity->setUserid('testuser_' . uniqid());
        $entity->setDepartmentId(random_int(1, 100));
        $entity->setScreenShotType(ScreenShotTypeEnum::CHAT);
        $entity->setScreenShotContent('Test screenshot content ' . uniqid());
        $entity->setSystem('Test System ' . uniqid());

        return $entity;
    }

    protected function getRepository(): ScreenOperateRecordRepository
    {
        $repository = self::getService(ScreenOperateRecordRepository::class);
        $this->assertInstanceOf(ScreenOperateRecordRepository::class, $repository);

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
        $this->assertSame($entity->getScreenShotType(), $savedEntity->getScreenShotType());
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
        $this->assertInstanceOf(ScreenOperateRecord::class, $result);
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

    public function testFindByScreenShotTypeReturnsMatchingRecords(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setScreenShotType(ScreenShotTypeEnum::CHAT);
        $entity2 = $this->createTestEntity();
        $entity2->setScreenShotType(ScreenShotTypeEnum::FILES);

        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['screenShotType' => ScreenShotTypeEnum::CHAT]);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertSame(ScreenShotTypeEnum::CHAT, $result[0]->getScreenShotType());
    }

    public function testFindByDepartmentIdReturnsMatchingRecords(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setDepartmentId(100);
        $entity2 = $this->createTestEntity();
        $entity2->setDepartmentId(200);

        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['departmentId' => 100]);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertSame(100, $result[0]->getDepartmentId());
    }

    public function testFindBySystemReturnsMatchingRecords(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setSystem('Windows 10');
        $entity2 = $this->createTestEntity();
        $entity2->setSystem('macOS');

        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findBy(['system' => 'Windows 10']);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertSame('Windows 10', $result[0]->getSystem());
    }

    private function createTestEntity(): ScreenOperateRecord
    {
        $entity = new ScreenOperateRecord();
        $entity->setTime(new \DateTimeImmutable());
        $entity->setUserid('testuser');
        $entity->setDepartmentId(1);
        $entity->setScreenShotType(ScreenShotTypeEnum::CHAT);
        $entity->setScreenShotContent('聊天截图内容');
        $entity->setSystem('Windows 11');

        return $entity;
    }

    public function testFindOneByWithSortingReturnsFirstMatch(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setUserid('sameUser');
        $entity1->setScreenShotType(ScreenShotTypeEnum::CHAT);
        $entity2 = $this->createTestEntity();
        $entity2->setUserid('sameUser');
        $entity2->setScreenShotType(ScreenShotTypeEnum::FILES);
        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findOneBy(['userid' => 'sameUser'], ['screenShotType' => 'ASC']);

        $this->assertNotNull($result);
        $this->assertSame(ScreenShotTypeEnum::CHAT, $result->getScreenShotType());
    }

    private function clearDatabase(): void
    {
        $entityManager = self::getService(EntityManagerInterface::class);
        $entityManager->createQuery('DELETE FROM ' . ScreenOperateRecord::class)->execute();
    }
}
