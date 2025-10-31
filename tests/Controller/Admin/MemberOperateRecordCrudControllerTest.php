<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Controller\Admin;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminControllerTestCase;
use WechatWorkSecurityBundle\Controller\Admin\MemberOperateRecordCrudController;
use WechatWorkSecurityBundle\Entity\MemberOperateRecord;

/**
 * @internal
 */
#[CoversClass(MemberOperateRecordCrudController::class)]
#[RunTestsInSeparateProcesses]
final class MemberOperateRecordCrudControllerTest extends AbstractEasyAdminControllerTestCase
{
    protected function getControllerService(): MemberOperateRecordCrudController
    {
        return self::getService(MemberOperateRecordCrudController::class);
    }

    public static function provideIndexPageHeaders(): iterable
    {
        yield 'ID' => ['ID'];
        yield '操作时间' => ['操作时间'];
        yield '操作者用户ID' => ['操作者用户ID'];
        yield '操作类型' => ['操作类型'];
        yield '相关数据' => ['相关数据'];
        yield '操作者IP' => ['操作者IP'];
        yield '创建时间' => ['创建时间'];
        yield '更新时间' => ['更新时间'];
    }

    public static function provideEditPageFields(): iterable
    {
        yield 'time' => ['time'];
        yield 'userid' => ['userid'];
        yield 'operType' => ['operType'];
        yield 'detailInfo' => ['detailInfo'];
        yield 'ip' => ['ip'];
    }

    protected function getEntityFqcn(): string
    {
        return MemberOperateRecord::class;
    }

    protected function getControllerFqcn(): string
    {
        return MemberOperateRecordCrudController::class;
    }

    public function testCrudUrlsAreSecured(): void
    {
        $client = self::createClientWithDatabase();
        self::getClient($client);

        // Test that CRUD URLs are secured and require authentication
        $this->expectException(AccessDeniedException::class);
        $client->request('GET', '/admin');
    }

    public function testEntityFqcnIsCorrect(): void
    {
        $fqcn = $this->getEntityFqcn();
        self::assertSame(MemberOperateRecord::class, $fqcn);
    }

    public function testControllerFqcnIsCorrect(): void
    {
        $fqcn = $this->getControllerFqcn();
        self::assertSame(MemberOperateRecordCrudController::class, $fqcn);
    }

    protected function createAuthenticatedClientFixed(): KernelBrowser
    {
        // 确保内核已关闭
        if (self::$booted) {
            self::ensureKernelShutdown();
        }

        $client = self::createClientWithDatabase();
        $client->loginUser(self::createAdminUser());

        return $client;
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideNewPageFields(): iterable
    {
        yield 'time' => ['time'];
        yield 'userid' => ['userid'];
        yield 'operType' => ['operType'];
        yield 'detailInfo' => ['detailInfo'];
        yield 'ip' => ['ip'];
    }
}
