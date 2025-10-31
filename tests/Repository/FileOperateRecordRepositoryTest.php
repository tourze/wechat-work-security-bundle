<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatWorkSecurityBundle\Entity\FileOperateRecord;
use WechatWorkSecurityBundle\Enum\FileOperateDeviceCodeEnum;
use WechatWorkSecurityBundle\Repository\FileOperateRecordRepository;

/**
 * @template-extends AbstractRepositoryTestCase<FileOperateRecord>
 * @internal
 */
#[CoversClass(FileOperateRecordRepository::class)]
#[RunTestsInSeparateProcesses]
final class FileOperateRecordRepositoryTest extends AbstractRepositoryTestCase
{
    protected function onSetUp(): void
    {
        // 无需特殊设置
    }

    protected function createNewEntity(): object
    {
        $entity = new FileOperateRecord();
        $entity->setTime(new \DateTimeImmutable());
        $entity->setUserid('testuser_' . uniqid());
        $entity->setExternalUser('external_' . uniqid());
        $entity->setOperation('test_operation');
        $entity->setFileInfo('test_file.pdf');
        $entity->setFileMd5('md5_' . uniqid());
        $entity->setFileSize('1024');
        $entity->setApplicantName('Test Applicant');
        $entity->setDeviceType(FileOperateDeviceCodeEnum::FIRM);
        $entity->setDeviceCode('device_' . uniqid());

        return $entity;
    }

    protected function getRepository(): FileOperateRecordRepository
    {
        $repository = self::getService(FileOperateRecordRepository::class);
        $this->assertInstanceOf(FileOperateRecordRepository::class, $repository);

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
        $this->assertSame($entity->getOperation(), $savedEntity->getOperation());
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
        $this->assertInstanceOf(FileOperateRecord::class, $result);
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

    private function createTestEntity(): FileOperateRecord
    {
        $entity = new FileOperateRecord();
        $entity->setTime(new \DateTimeImmutable());
        $entity->setUserid('testuser');
        $entity->setExternalUser('external_user');
        $entity->setOperation('download');
        $entity->setFileInfo('test_file.pdf');
        $entity->setFileMd5('abc123def456');
        $entity->setFileSize('1024');
        $entity->setApplicantName('申请人');
        $entity->setDeviceType(FileOperateDeviceCodeEnum::FIRM);
        $entity->setDeviceCode('device001');

        return $entity;
    }

    public function testFindOneByWithSortingReturnsFirstMatch(): void
    {
        $this->clearDatabase();
        $entity1 = $this->createTestEntity();
        $entity1->setUserid('sameUser');
        $entity1->setOperation('download');
        $entity2 = $this->createTestEntity();
        $entity2->setUserid('sameUser');
        $entity2->setOperation('upload');
        $this->getRepository()->save($entity1);
        $this->getRepository()->save($entity2);

        $result = $this->getRepository()->findOneBy(['userid' => 'sameUser'], ['operation' => 'ASC']);

        $this->assertNotNull($result);
        $this->assertSame('download', $result->getOperation());
    }

    private function clearDatabase(): void
    {
        $entityManager = self::getService(EntityManagerInterface::class);
        $entityManager->createQuery('DELETE FROM ' . FileOperateRecord::class)->execute();
    }
}
