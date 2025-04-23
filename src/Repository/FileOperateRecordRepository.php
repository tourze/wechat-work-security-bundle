<?php

namespace WechatWorkSecurityBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use WechatWorkSecurityBundle\Entity\FileOperateRecord;

/**
 * @method FileOperateRecord|null find($id, $lockMode = null, $lockVersion = null)
 * @method FileOperateRecord|null findOneBy(array $criteria, array $orderBy = null)
 * @method FileOperateRecord[]    findAll()
 * @method FileOperateRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FileOperateRecordRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FileOperateRecord::class);
    }
}
