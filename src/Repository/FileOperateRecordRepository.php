<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use WechatWorkSecurityBundle\Entity\FileOperateRecord;

/**
 * @extends ServiceEntityRepository<FileOperateRecord>
 */
#[AsRepository(entityClass: FileOperateRecord::class)]
class FileOperateRecordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileOperateRecord::class);
    }

    public function save(FileOperateRecord $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FileOperateRecord $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
