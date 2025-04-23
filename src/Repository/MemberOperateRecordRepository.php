<?php

namespace WechatWorkSecurityBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use WechatWorkSecurityBundle\Entity\MemberOperateRecord;

/**
 * @method MemberOperateRecord|null find($id, $lockMode = null, $lockVersion = null)
 * @method MemberOperateRecord|null findOneBy(array $criteria, array $orderBy = null)
 * @method MemberOperateRecord[]    findAll()
 * @method MemberOperateRecord[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MemberOperateRecordRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MemberOperateRecord::class);
    }
}
