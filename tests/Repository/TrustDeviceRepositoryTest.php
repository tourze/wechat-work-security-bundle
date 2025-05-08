<?php

namespace WechatWorkSecurityBundle\Tests\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Entity\TrustDevice;
use WechatWorkSecurityBundle\Repository\TrustDeviceRepository;

class TrustDeviceRepositoryTest extends TestCase
{
    private TrustDeviceRepository $repository;
    private EntityManagerInterface $entityManager;
    private ManagerRegistry $registry;
    private ClassMetadata $classMetadata;

    protected function setUp(): void
    {
        // 创建模拟对象
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->registry = $this->createMock(ManagerRegistry::class);
        $this->classMetadata = $this->createMock(ClassMetadata::class);

        // 配置ClassMetadata
        $this->classMetadata->name = TrustDevice::class;

        // 配置EntityManager以返回ClassMetadata
        $this->entityManager->expects($this->any())
            ->method('getClassMetadata')
            ->with(TrustDevice::class)
            ->willReturn($this->classMetadata);

        // 配置registry模拟对象以返回entityManager
        $this->registry->expects($this->any())
            ->method('getManagerForClass')
            ->with(TrustDevice::class)
            ->willReturn($this->entityManager);

        $this->registry->expects($this->any())
            ->method('getManager')
            ->willReturn($this->entityManager);

        // 创建仓库实例
        $this->repository = new TrustDeviceRepository($this->registry);
    }

    public function testConstruct_shouldCreateValidRepository(): void
    {
        $this->assertInstanceOf(TrustDeviceRepository::class, $this->repository);
    }
}
