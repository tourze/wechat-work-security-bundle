<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminControllerTestCase;
use WechatWorkSecurityBundle\Controller\Admin\ScreenOperateRecordCrudController;
use WechatWorkSecurityBundle\Entity\ScreenOperateRecord;

/**
 * @internal
 */
#[CoversClass(ScreenOperateRecordCrudController::class)]
#[RunTestsInSeparateProcesses]
final class ScreenOperateRecordCrudControllerTest extends AbstractEasyAdminControllerTestCase
{
    protected function getControllerService(): ScreenOperateRecordCrudController
    {
        return self::getService(ScreenOperateRecordCrudController::class);
    }

    public static function provideIndexPageHeaders(): iterable
    {
        yield 'ID' => ['ID'];
        yield '操作时间' => ['操作时间'];
        yield '企业账号ID' => ['企业账号ID'];
        yield '部门ID' => ['部门ID'];
        yield '截屏内容类型' => ['截屏内容类型'];
        yield '截屏内容' => ['截屏内容'];
        yield '操作系统' => ['操作系统'];
        yield '创建时间' => ['创建时间'];
        yield '更新时间' => ['更新时间'];
    }

    public static function provideEditPageFields(): iterable
    {
        yield 'time' => ['time'];
        yield 'userid' => ['userid'];
        yield 'departmentId' => ['departmentId'];
        yield 'screenShotType' => ['screenShotType'];
        yield 'screenShotContent' => ['screenShotContent'];
        yield 'system' => ['system'];
    }

    protected function getEntityFqcn(): string
    {
        return ScreenOperateRecord::class;
    }

    protected function getControllerFqcn(): string
    {
        return ScreenOperateRecordCrudController::class;
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
        self::assertSame(ScreenOperateRecord::class, $fqcn);
    }

    public function testControllerFqcnIsCorrect(): void
    {
        $fqcn = $this->getControllerFqcn();
        self::assertSame(ScreenOperateRecordCrudController::class, $fqcn);
    }

    public function testRequiredFieldValidation(): void
    {
        $controller = $this->getControllerService();
        $fields = $controller->configureFields('new');

        $screenShotTypeField = null;
        foreach ($fields as $field) {
            if ($field instanceof ChoiceField
                && 'screenShotType' === $field->getAsDto()->getProperty()) {
                $screenShotTypeField = $field;
                break;
            }
        }

        self::assertNotNull($screenShotTypeField, 'screenShotType field should exist');

        // 检查字段的表单约束
        $dto = $screenShotTypeField->getAsDto();
        $formTypeOptions = $dto->getFormTypeOptions();
        self::assertTrue($formTypeOptions['required'] ?? false, 'screenShotType field should be required');
    }

    public function testValidationErrors(): void
    {
        $client = $this->createAuthenticatedClient();

        // Access the new form page using proper URL generation
        $crawler = $client->request('GET', $this->generateAdminUrl(Action::NEW));
        $this->assertResponseIsSuccessful();

        // Submit empty form to trigger validation errors
        $form = $crawler->selectButton('Create')->form();
        $crawler = $client->submit($form);

        $this->assertResponseStatusCodeSame(422);

        // Check that validation error messages are present
        $errorText = $crawler->filter('.invalid-feedback')->text();
        $this->assertTrue(
            str_contains($errorText, 'should not be blank') || str_contains($errorText, 'The selected choice is invalid'),
            'Expected validation error message not found. Got: ' . $errorText
        );
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
        yield 'departmentId' => ['departmentId'];
        yield 'screenShotType' => ['screenShotType'];
        yield 'screenShotContent' => ['screenShotContent'];
        yield 'system' => ['system'];
    }
}
