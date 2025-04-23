<?php

namespace WechatWorkSecurityBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use WechatWorkSecurityBundle\Entity\ScreenOperateRecord;

/**
 * @method ScreenOperateRecord|null find($id, $lockMode = null, $lockVersion = null)
 * @method ScreenOperateRecord|null findOneBy(array $criteria, array $orderBy = null)
 * @method ScreenOperateRecord[]    findAll()
 * @method ScreenOperateRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScreenOperateRecordRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ScreenOperateRecord::class);
    }
}
