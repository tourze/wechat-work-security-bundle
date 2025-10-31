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
use WechatWorkSecurityBundle\Controller\Admin\TrustDeviceCrudController;
use WechatWorkSecurityBundle\Entity\TrustDevice;

/**
 * @internal
 */
#[CoversClass(TrustDeviceCrudController::class)]
#[RunTestsInSeparateProcesses]
final class TrustDeviceCrudControllerTest extends AbstractEasyAdminControllerTestCase
{
    protected function getControllerService(): TrustDeviceCrudController
    {
        return self::getService(TrustDeviceCrudController::class);
    }

    public static function provideIndexPageHeaders(): iterable
    {
        yield 'ID' => ['ID'];
        yield '设备类型' => ['设备类型'];
        yield '设备编码' => ['设备编码'];
        yield '操作系统' => ['操作系统'];
        yield 'MAC地址' => ['MAC地址'];
        yield '主板UUID' => ['主板UUID'];
        yield '硬盘UUID' => ['硬盘UUID'];
        yield 'Windows域' => ['Windows域'];
        yield '计算机名' => ['计算机名'];
        yield 'Mac序列号' => ['Mac序列号'];
        yield '最后登录时间' => ['最后登录时间'];
        yield '最后登录用户' => ['最后登录用户'];
        yield '确认时间戳' => ['确认时间戳'];
        yield '确认用户' => ['确认用户'];
        yield '审批用户' => ['审批用户'];
        yield '设备来源' => ['设备来源'];
        yield '设备状态' => ['设备状态'];
        yield '创建时间' => ['创建时间'];
        yield '更新时间' => ['更新时间'];
    }

    public static function provideEditPageFields(): iterable
    {
        yield 'type' => ['type'];
        yield 'deviceCode' => ['deviceCode'];
        yield 'system' => ['system'];
        yield 'macAddr' => ['macAddr'];
        yield 'motherboardUuid' => ['motherboardUuid'];
        yield 'harddiskUuid' => ['harddiskUuid'];
        yield 'domain' => ['domain'];
        yield 'pcName' => ['pcName'];
        yield 'seqNo' => ['seqNo'];
        yield 'lastLoginTime' => ['lastLoginTime'];
        yield 'lastLoginUserid' => ['lastLoginUserid'];
        yield 'confirmTimestamp' => ['confirmTimestamp'];
        yield 'confirmUserid' => ['confirmUserid'];
        yield 'approvedUserid' => ['approvedUserid'];
        yield 'source' => ['source'];
        yield 'status' => ['status'];
    }

    protected function getEntityFqcn(): string
    {
        return TrustDevice::class;
    }

    protected function getControllerFqcn(): string
    {
        return TrustDeviceCrudController::class;
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
        self::assertSame(TrustDevice::class, $fqcn);
    }

    public function testControllerFqcnIsCorrect(): void
    {
        $fqcn = $this->getControllerFqcn();
        self::assertSame(TrustDeviceCrudController::class, $fqcn);
    }

    public function testRequiredFieldValidation(): void
    {
        $controller = $this->getControllerService();
        $fields = $controller->configureFields('new');

        $sourceField = null;
        $statusField = null;
        foreach ($fields as $field) {
            if ($field instanceof ChoiceField) {
                $property = $field->getAsDto()->getProperty();
                if ('source' === $property) {
                    $sourceField = $field;
                } elseif ('status' === $property) {
                    $statusField = $field;
                }
            }
        }

        self::assertNotNull($sourceField, 'source field should exist');
        $sourceDto = $sourceField->getAsDto();
        $sourceFormTypeOptions = $sourceDto->getFormTypeOptions();
        self::assertTrue($sourceFormTypeOptions['required'] ?? false, 'source field should be required');

        self::assertNotNull($statusField, 'status field should exist');
        $statusDto = $statusField->getAsDto();
        $statusFormTypeOptions = $statusDto->getFormTypeOptions();
        self::assertTrue($statusFormTypeOptions['required'] ?? false, 'status field should be required');
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
        yield 'type' => ['type'];
        yield 'deviceCode' => ['deviceCode'];
        yield 'system' => ['system'];
        yield 'macAddr' => ['macAddr'];
        yield 'motherboardUuid' => ['motherboardUuid'];
        yield 'harddiskUuid' => ['harddiskUuid'];
        yield 'domain' => ['domain'];
        yield 'pcName' => ['pcName'];
        yield 'seqNo' => ['seqNo'];
        yield 'lastLoginTime' => ['lastLoginTime'];
        yield 'lastLoginUserid' => ['lastLoginUserid'];
        yield 'confirmTimestamp' => ['confirmTimestamp'];
        yield 'confirmUserid' => ['confirmUserid'];
        yield 'approvedUserid' => ['approvedUserid'];
        yield 'source' => ['source'];
        yield 'status' => ['status'];
    }
}
