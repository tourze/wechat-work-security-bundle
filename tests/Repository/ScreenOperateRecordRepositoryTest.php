<?php

namespace WechatWorkSecurityBundle\Tests\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Repository\ScreenOperateRecordRepository;

class ScreenOperateRecordRepositoryTest extends TestCase
{
    public function test_extends_service_entity_repository(): void
    {
        $reflection = new \ReflectionClass(ScreenOperateRecordRepository::class);
        $this->assertTrue($reflection->isSubclassOf(ServiceEntityRepository::class));
    }

    public function test_constructor_parameter_is_correct(): void
    {
        $reflection = new \ReflectionClass(ScreenOperateRecordRepository::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor);
        $this->assertCount(1, $constructor->getParameters());

        $parameter = $constructor->getParameters()[0];
        $this->assertSame('registry', $parameter->getName());
    }

    public function test_has_proper_phpdoc_annotations(): void
    {
        $reflection = new \ReflectionClass(ScreenOperateRecordRepository::class);
        $docComment = $reflection->getDocComment();

        $this->assertNotFalse($docComment);
        $this->assertStringContainsString('ScreenOperateRecord|null find(', $docComment);
        $this->assertStringContainsString('ScreenOperateRecord|null findOneBy(', $docComment);
        $this->assertStringContainsString('ScreenOperateRecord[]    findAll()', $docComment);
        $this->assertStringContainsString('ScreenOperateRecord[]    findBy(', $docComment);
    }
}
