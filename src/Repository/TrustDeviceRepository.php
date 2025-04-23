<?php

namespace WechatWorkSecurityBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DoctrineEnhanceBundle\Repository\CommonRepositoryAware;
use WechatWorkSecurityBundle\Entity\TrustDevice;

/**
 * @method TrustDevice|null find($id, $lockMode = null, $lockVersion = null)
 * @method TrustDevice|null findOneBy(array $criteria, array $orderBy = null)
 * @method TrustDevice[]    findAll()
 * @method TrustDevice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrustDeviceRepository extends ServiceEntityRepository
{
    use CommonRepositoryAware;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TrustDevice::class);
    }
}
