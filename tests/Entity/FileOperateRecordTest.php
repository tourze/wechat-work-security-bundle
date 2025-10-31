<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatWorkSecurityBundle\Entity\FileOperateRecord;
use WechatWorkSecurityBundle\Enum\FileOperateDeviceCodeEnum;

/**
 * @internal
 */
#[CoversClass(FileOperateRecord::class)]
final class FileOperateRecordTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new FileOperateRecord();
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'userid' => ['userid', 'test_user_123'],
            'operation' => ['operation', 'download'],
            'fileInfo' => ['fileInfo', 'document.pdf'],
        ];
    }

    public function testGetIdReturnsZeroByDefault(): void
    {
        $entity = new FileOperateRecord();
        $this->assertSame(0, $entity->getId());
    }

    public function testTimeGetterAndSetter(): void
    {
        $entity = new FileOperateRecord();
        $this->assertNull($entity->getTime());

        $time = new \DateTime('2024-01-01 12:00:00');
        $entity->setTime($time);

        $this->assertSame($time, $entity->getTime());
    }

    public function testTimeSetterWithNull(): void
    {
        $entity = new FileOperateRecord();
        $entity->setTime(null);
        $this->assertNull($entity->getTime());
    }

    public function testUseridGetterAndSetter(): void
    {
        $entity = new FileOperateRecord();
        $this->assertNull($entity->getUserid());

        $userid = 'test_user_123';
        $entity->setUserid($userid);

        $this->assertSame($userid, $entity->getUserid());
    }

    public function testUseridSetterWithNull(): void
    {
        $entity = new FileOperateRecord();
        $entity->setUserid(null);
        $this->assertNull($entity->getUserid());
    }

    public function testExternalUserGetterAndSetter(): void
    {
        $entity = new FileOperateRecord();
        $this->assertNull($entity->getExternalUser());

        $externalUser = 'external_user_456';
        $entity->setExternalUser($externalUser);

        $this->assertSame($externalUser, $entity->getExternalUser());
    }

    public function testExternalUserSetterWithNull(): void
    {
        $entity = new FileOperateRecord();
        $entity->setExternalUser(null);
        $this->assertNull($entity->getExternalUser());
    }

    public function testOperationGetterAndSetter(): void
    {
        $entity = new FileOperateRecord();
        $this->assertNull($entity->getOperation());

        $operation = 'download';
        $entity->setOperation($operation);

        $this->assertSame($operation, $entity->getOperation());
    }

    public function testOperationSetterWithNull(): void
    {
        $entity = new FileOperateRecord();
        $entity->setOperation(null);
        $this->assertNull($entity->getOperation());
    }

    public function testFileInfoGetterAndSetter(): void
    {
        $entity = new FileOperateRecord();
        $this->assertNull($entity->getFileInfo());

        $fileInfo = 'document.pdf';
        $entity->setFileInfo($fileInfo);

        $this->assertSame($fileInfo, $entity->getFileInfo());
    }

    public function testFileInfoSetterWithNull(): void
    {
        $entity = new FileOperateRecord();
        $entity->setFileInfo(null);
        $this->assertNull($entity->getFileInfo());
    }

    public function testFileMd5GetterAndSetter(): void
    {
        $entity = new FileOperateRecord();
        $this->assertNull($entity->getFileMd5());

        $md5 = 'a1b2c3d4e5f6789012345678901234567890abcd';
        $entity->setFileMd5($md5);

        $this->assertSame($md5, $entity->getFileMd5());
    }

    public function testFileMd5SetterWithNull(): void
    {
        $entity = new FileOperateRecord();
        $entity->setFileMd5(null);
        $this->assertNull($entity->getFileMd5());
    }

    public function testFileSizeGetterAndSetter(): void
    {
        $entity = new FileOperateRecord();
        $this->assertNull($entity->getFileSize());

        $fileSize = '1024000';
        $entity->setFileSize($fileSize);

        $this->assertSame($fileSize, $entity->getFileSize());
    }

    public function testFileSizeSetterWithNull(): void
    {
        $entity = new FileOperateRecord();
        $entity->setFileSize(null);
        $this->assertNull($entity->getFileSize());
    }

    public function testApplicantNameGetterAndSetter(): void
    {
        $entity = new FileOperateRecord();
        $this->assertNull($entity->getApplicantName());

        $applicantName = '张三';
        $entity->setApplicantName($applicantName);

        $this->assertSame($applicantName, $entity->getApplicantName());
    }

    public function testApplicantNameSetterWithNull(): void
    {
        $entity = new FileOperateRecord();
        $entity->setApplicantName(null);
        $this->assertNull($entity->getApplicantName());
    }

    public function testDeviceTypeGetterAndSetter(): void
    {
        $entity = new FileOperateRecord();
        $this->assertSame(FileOperateDeviceCodeEnum::FIRM, $entity->getDeviceType());

        $deviceType = FileOperateDeviceCodeEnum::PERSONAGE;
        $entity->setDeviceType($deviceType);

        $this->assertSame($deviceType, $entity->getDeviceType());
    }

    public function testDeviceTypeHasDefaultValue(): void
    {
        $freshEntity = new FileOperateRecord();
        $this->assertSame(FileOperateDeviceCodeEnum::FIRM, $freshEntity->getDeviceType());
    }

    public function testDeviceCodeGetterAndSetter(): void
    {
        $entity = new FileOperateRecord();
        $this->assertNull($entity->getDeviceCode());

        $deviceCode = 'device_001';
        $entity->setDeviceCode($deviceCode);

        $this->assertSame($deviceCode, $entity->getDeviceCode());
    }

    public function testDeviceCodeSetterWithNull(): void
    {
        $entity = new FileOperateRecord();
        $entity->setDeviceCode(null);
        $this->assertNull($entity->getDeviceCode());
    }

    public function testCreateTimeGetterAndSetter(): void
    {
        $entity = new FileOperateRecord();
        $this->assertNull($entity->getCreateTime());

        $createTime = new \DateTimeImmutable('2024-01-01 10:00:00');
        $entity->setCreateTime($createTime);

        $this->assertSame($createTime, $entity->getCreateTime());
    }

    public function testCreateTimeSetterWithNull(): void
    {
        $entity = new FileOperateRecord();
        $entity->setCreateTime(null);
        $this->assertNull($entity->getCreateTime());
    }

    public function testUpdateTimeGetterAndSetter(): void
    {
        $entity = new FileOperateRecord();
        $this->assertNull($entity->getUpdateTime());

        $updateTime = new \DateTimeImmutable('2024-01-01 11:00:00');
        $entity->setUpdateTime($updateTime);

        $this->assertSame($updateTime, $entity->getUpdateTime());
    }

    public function testUpdateTimeSetterWithNull(): void
    {
        $entity = new FileOperateRecord();
        $entity->setUpdateTime(null);
        $this->assertNull($entity->getUpdateTime());
    }

    public function testEntityWithAllPropertiesSet(): void
    {
        $entity = new FileOperateRecord();
        $time = new \DateTimeImmutable('2024-01-01 12:00:00');
        $createTime = new \DateTimeImmutable('2024-01-01 10:00:00');
        $updateTime = new \DateTimeImmutable('2024-01-01 11:00:00');

        $entity->setTime($time);
        $entity->setUserid('user123');
        $entity->setExternalUser('external456');
        $entity->setOperation('download');
        $entity->setFileInfo('document.pdf');
        $entity->setFileMd5('abc123');
        $entity->setFileSize('1024');
        $entity->setApplicantName('张三');
        $entity->setDeviceType(FileOperateDeviceCodeEnum::FIRM);
        $entity->setDeviceCode('device001');
        $entity->setCreateTime($createTime);
        $entity->setUpdateTime($updateTime);

        $this->assertSame($time, $entity->getTime());
        $this->assertSame('user123', $entity->getUserid());
        $this->assertSame('external456', $entity->getExternalUser());
        $this->assertSame('download', $entity->getOperation());
        $this->assertSame('document.pdf', $entity->getFileInfo());
        $this->assertSame('abc123', $entity->getFileMd5());
        $this->assertSame('1024', $entity->getFileSize());
        $this->assertSame('张三', $entity->getApplicantName());
        $this->assertSame(FileOperateDeviceCodeEnum::FIRM, $entity->getDeviceType());
        $this->assertSame('device001', $entity->getDeviceCode());
        $this->assertSame($createTime, $entity->getCreateTime());
        $this->assertSame($updateTime, $entity->getUpdateTime());
    }
}
