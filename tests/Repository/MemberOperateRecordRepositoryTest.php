<?php

namespace WechatWorkSecurityBundle\Tests\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Repository\MemberOperateRecordRepository;

class MemberOperateRecordRepositoryTest extends TestCase
{
    public function test_extends_service_entity_repository(): void
    {
        $reflection = new \ReflectionClass(MemberOperateRecordRepository::class);
        $this->assertTrue($reflection->isSubclassOf(ServiceEntityRepository::class));
    }

    public function test_implements_expected_methods(): void
    {
        $this->assertTrue(is_callable([MemberOperateRecordRepository::class, '__construct']));

        // 验证继承的方法存在
        $this->assertTrue(is_callable([MemberOperateRecordRepository::class, 'find']));
        $this->assertTrue(is_callable([MemberOperateRecordRepository::class, 'findOneBy']));
        $this->assertTrue(is_callable([MemberOperateRecordRepository::class, 'findAll']));
        $this->assertTrue(is_callable([MemberOperateRecordRepository::class, 'findBy']));
    }

    public function test_constructor_parameter_is_correct(): void
    {
        $reflection = new \ReflectionClass(MemberOperateRecordRepository::class);
        $constructor = $reflection->getConstructor();

        $this->assertNotNull($constructor);
        $this->assertCount(1, $constructor->getParameters());

        $parameter = $constructor->getParameters()[0];
        $this->assertSame('registry', $parameter->getName());
    }

    public function test_has_proper_phpdoc_annotations(): void
    {
        $reflection = new \ReflectionClass(MemberOperateRecordRepository::class);
        $docComment = $reflection->getDocComment();

        $this->assertNotFalse($docComment);
        $this->assertStringContainsString('MemberOperateRecord|null find(', $docComment);
        $this->assertStringContainsString('MemberOperateRecord|null findOneBy(', $docComment);
        $this->assertStringContainsString('MemberOperateRecord[]    findAll()', $docComment);
        $this->assertStringContainsString('MemberOperateRecord[]    findBy(', $docComment);
    }
}
