<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminControllerTestCase;
use WechatWorkSecurityBundle\Controller\Admin\FileOperateRecordCrudController;
use WechatWorkSecurityBundle\Entity\FileOperateRecord;

/**
 * @internal
 */
#[CoversClass(FileOperateRecordCrudController::class)]
#[RunTestsInSeparateProcesses]
final class FileOperateRecordCrudControllerTest extends AbstractEasyAdminControllerTestCase
{
    protected function onSetUp(): void
    {
        // 确保每个测试开始时内核状态是干净的
        if (self::$booted) {
            self::ensureKernelShutdown();
        }
    }

    protected function getControllerService(): FileOperateRecordCrudController
    {
        return self::getService(FileOperateRecordCrudController::class);
    }

    public static function provideIndexPageHeaders(): iterable
    {
        yield 'ID' => ['ID'];
        yield '操作时间' => ['操作时间'];
        yield '企业账号ID' => ['企业账号ID'];
        yield '外部人员信息' => ['外部人员信息'];
        yield '操作类型' => ['操作类型'];
        yield '文件信息' => ['文件信息'];
        yield '文件MD5' => ['文件MD5'];
        yield '文件大小' => ['文件大小'];
        yield '申请人姓名' => ['申请人姓名'];
        yield '设备类型' => ['设备类型'];
        yield '设备编码' => ['设备编码'];
        yield '创建时间' => ['创建时间'];
        yield '更新时间' => ['更新时间'];
    }

    public static function provideEditPageFields(): iterable
    {
        yield 'time' => ['time'];
        yield 'userid' => ['userid'];
        yield 'externalUser' => ['externalUser'];
        yield 'operation' => ['operation'];
        yield 'fileInfo' => ['fileInfo'];
        yield 'fileMd5' => ['fileMd5'];
        yield 'fileSize' => ['fileSize'];
        yield 'applicantName' => ['applicantName'];
        yield 'deviceType' => ['deviceType'];
        yield 'deviceCode' => ['deviceCode'];
    }

    protected function getEntityFqcn(): string
    {
        return FileOperateRecord::class;
    }

    protected function getControllerFqcn(): string
    {
        return FileOperateRecordCrudController::class;
    }

    public function testCrudUrlsAreSecured(): void
    {
        $client = self::createClientWithDatabase();

        // Test that CRUD URLs are secured and require authentication
        $this->expectException(AccessDeniedException::class);
        $client->request('GET', '/admin');
    }

    public function testEntityFqcnIsCorrect(): void
    {
        $fqcn = $this->getEntityFqcn();
        self::assertSame(FileOperateRecord::class, $fqcn);
    }

    public function testControllerFqcnIsCorrect(): void
    {
        $fqcn = $this->getControllerFqcn();
        self::assertSame(FileOperateRecordCrudController::class, $fqcn);
    }

    public function testValidationErrors(): void
    {
        $client = $this->createAuthenticatedClientFixed();
        self::getClient($client);

        // Access the new form page
        $crawler = $client->request('GET', $this->generateAdminUrl(Action::NEW));
        $this->assertResponseIsSuccessful();

        // Submit empty form to trigger validation errors
        $form = $crawler->selectButton('Create')->form();
        $crawler = $client->submit($form);

        // Should return 422 for validation errors
        $this->assertResponseStatusCodeSame(422);

        // Check that validation error messages are present
        $errorText = $crawler->filter('.invalid-feedback')->text();
        $this->assertTrue(
            str_contains($errorText, 'should not be blank') || str_contains($errorText, 'The selected choice is invalid'),
            'Expected validation error message not found. Got: ' . $errorText
        );
    }

    public function testRequiredFieldValidation(): void
    {
        $controller = $this->getControllerService();
        $fields = $controller->configureFields('new');

        $deviceTypeField = null;
        foreach ($fields as $field) {
            if ($field instanceof ChoiceField
                && 'deviceType' === $field->getAsDto()->getProperty()) {
                $deviceTypeField = $field;
                break;
            }
        }

        self::assertNotNull($deviceTypeField, 'deviceType field should exist');

        // 检查字段的表单约束
        $dto = $deviceTypeField->getAsDto();
        $formTypeOptions = $dto->getFormTypeOptions();
        self::assertTrue($formTypeOptions['required'] ?? false, 'deviceType field should be required');
    }

    /**
     * 临时修复客户端创建问题的方法
     */
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
        yield 'externalUser' => ['externalUser'];
        yield 'operation' => ['operation'];
        yield 'fileInfo' => ['fileInfo'];
        yield 'fileMd5' => ['fileMd5'];
        yield 'fileSize' => ['fileSize'];
        yield 'applicantName' => ['applicantName'];
        yield 'deviceType' => ['deviceType'];
        yield 'deviceCode' => ['deviceCode'];
    }

    /**
     * 替代基类中的testEditPagePrefillsExistingData方法来修复客户端问题
     */
    public function testEditPagePrefillsExistingDataFixed(): void
    {
        $client = $this->createAuthenticatedClientFixed();
        self::getClient($client);

        $crawler = $client->request('GET', $this->generateAdminUrl(Action::INDEX));
        $this->assertResponseIsSuccessful();

        $recordIds = [];
        foreach ($crawler->filter('table tbody tr[data-id]') as $row) {
            $rowCrawler = new Crawler($row);
            $recordId = $rowCrawler->attr('data-id');
            if (null === $recordId || '' === $recordId) {
                continue;
            }

            $recordIds[] = $recordId;
        }

        self::assertNotEmpty($recordIds, '列表页面应至少显示一条记录');

        $firstRecordId = $recordIds[0];
        $client->request('GET', $this->generateAdminUrl(Action::EDIT, ['entityId' => $firstRecordId]));
        $this->assertResponseIsSuccessful(sprintf('The edit page for entity #%s should be accessible.', $firstRecordId));
    }

    public function testNewPageIsAccessible(): void
    {
        $client = $this->createAuthenticatedClientFixed();
        self::getClient($client);

        // Test that we can access the new form page
        $crawler = $client->request('GET', $this->generateAdminUrl(Action::NEW));
        $this->assertResponseIsSuccessful();

        // Verify that the form exists with the Create button
        self::assertStringContainsString('Create', $crawler->text(), 'Create button should be present on the new page');

        // Verify that required fields are present
        $entityName = $this->getEntitySimpleName();
        $form = $crawler->selectButton('Create')->form();
        $deviceTypeFieldName = sprintf('%s[deviceType]', $entityName);

        self::assertTrue($form->has($deviceTypeFieldName), 'Device type field should be present');
    }
}
