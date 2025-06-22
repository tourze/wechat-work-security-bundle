<?php

namespace WechatWorkSecurityBundle\Tests\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Repository\TrustDeviceRepository;

class TrustDeviceRepositoryTest extends TestCase
{
    public function test_extends_service_entity_repository(): void
    {
        $reflection = new \ReflectionClass(TrustDeviceRepository::class);
        $this->assertTrue($reflection->isSubclassOf(ServiceEntityRepository::class));
    }

    public function test_implements_expected_methods(): void
    {
        $this->assertTrue(is_callable([TrustDeviceRepository::class, '__construct']));

        // 验证继承的方法存在
        $this->assertTrue(is_callable([TrustDeviceRepository::class, 'find']));
        $this->assertTrue(is_callable([TrustDeviceRepository::class, 'findOneBy']));
        $this->assertTrue(is_callable([TrustDeviceRepository::class, 'findAll']));
        $this->assertTrue(is_callable([TrustDeviceRepository::class, 'findBy']));
    }

    public function test_constructor_parameter_is_correct(): void
    {
        $reflection = new \ReflectionClass(TrustDeviceRepository::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor);
        $this->assertCount(1, $constructor->getParameters());

        $parameter = $constructor->getParameters()[0];
        $this->assertSame('registry', $parameter->getName());
    }

    public function test_has_proper_phpdoc_annotations(): void
    {
        $reflection = new \ReflectionClass(TrustDeviceRepository::class);
        $docComment = $reflection->getDocComment();

        $this->assertNotFalse($docComment);
        $this->assertStringContainsString('TrustDevice|null find(', $docComment);
        $this->assertStringContainsString('TrustDevice|null findOneBy(', $docComment);
        $this->assertStringContainsString('TrustDevice[]    findAll()', $docComment);
        $this->assertStringContainsString('TrustDevice[]    findBy(', $docComment);
    }
}
