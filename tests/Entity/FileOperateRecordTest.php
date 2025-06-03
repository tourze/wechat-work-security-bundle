<?php

namespace WechatWorkSecurityBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use WechatWorkSecurityBundle\Entity\FileOperateRecord;
use WechatWorkSecurityBundle\Enum\FileOperateDeviceCodeEnum;

class FileOperateRecordTest extends TestCase
{
    private FileOperateRecord $entity;

    protected function setUp(): void
    {
        $this->entity = new FileOperateRecord();
    }

    public function test_getId_returns_zero_by_default(): void
    {
        $this->assertSame(0, $this->entity->getId());
    }

    public function test_time_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getTime());

        $time = new \DateTime('2024-01-01 12:00:00');
        $this->entity->setTime($time);
        
        $this->assertSame($time, $this->entity->getTime());
    }

    public function test_time_setter_with_null(): void
    {
        $this->entity->setTime(null);
        $this->assertNull($this->entity->getTime());
    }

    public function test_userid_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getUserid());

        $userid = 'test_user_123';
        $this->entity->setUserid($userid);
        
        $this->assertSame($userid, $this->entity->getUserid());
    }

    public function test_userid_setter_with_null(): void
    {
        $this->entity->setUserid(null);
        $this->assertNull($this->entity->getUserid());
    }

    public function test_externalUser_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getExternalUser());

        $externalUser = 'external_user_456';
        $this->entity->setExternalUser($externalUser);
        
        $this->assertSame($externalUser, $this->entity->getExternalUser());
    }

    public function test_externalUser_setter_with_null(): void
    {
        $this->entity->setExternalUser(null);
        $this->assertNull($this->entity->getExternalUser());
    }

    public function test_operation_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getOperation());

        $operation = 'download';
        $this->entity->setOperation($operation);
        
        $this->assertSame($operation, $this->entity->getOperation());
    }

    public function test_operation_setter_with_null(): void
    {
        $this->entity->setOperation(null);
        $this->assertNull($this->entity->getOperation());
    }

    public function test_fileInfo_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getFileInfo());

        $fileInfo = 'document.pdf';
        $this->entity->setFileInfo($fileInfo);
        
        $this->assertSame($fileInfo, $this->entity->getFileInfo());
    }

    public function test_fileInfo_setter_with_null(): void
    {
        $this->entity->setFileInfo(null);
        $this->assertNull($this->entity->getFileInfo());
    }

    public function test_fileMd5_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getFileMd5());

        $md5 = 'a1b2c3d4e5f6789012345678901234567890abcd';
        $this->entity->setFileMd5($md5);
        
        $this->assertSame($md5, $this->entity->getFileMd5());
    }

    public function test_fileMd5_setter_with_null(): void
    {
        $this->entity->setFileMd5(null);
        $this->assertNull($this->entity->getFileMd5());
    }

    public function test_fileSize_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getFileSize());

        $fileSize = '1024000';
        $this->entity->setFileSize($fileSize);
        
        $this->assertSame($fileSize, $this->entity->getFileSize());
    }

    public function test_fileSize_setter_with_null(): void
    {
        $this->entity->setFileSize(null);
        $this->assertNull($this->entity->getFileSize());
    }

    public function test_applicantName_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getApplicantName());

        $applicantName = '张三';
        $this->entity->setApplicantName($applicantName);
        
        $this->assertSame($applicantName, $this->entity->getApplicantName());
    }

    public function test_applicantName_setter_with_null(): void
    {
        $this->entity->setApplicantName(null);
        $this->assertNull($this->entity->getApplicantName());
    }

    public function test_deviceType_getter_and_setter(): void
    {
        $this->assertSame(FileOperateDeviceCodeEnum::FIRM, $this->entity->getDeviceType());

        $deviceType = FileOperateDeviceCodeEnum::PERSONAGE;
        $this->entity->setDeviceType($deviceType);
        
        $this->assertSame($deviceType, $this->entity->getDeviceType());
    }

    public function test_deviceType_setter_with_null(): void
    {
        $this->entity->setDeviceType(null);
        $this->assertNull($this->entity->getDeviceType());
    }

    public function test_deviceType_has_default_value(): void
    {
        $freshEntity = new FileOperateRecord();
        $this->assertSame(FileOperateDeviceCodeEnum::FIRM, $freshEntity->getDeviceType());
    }

    public function test_deviceCode_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getDeviceCode());

        $deviceCode = 'device_001';
        $this->entity->setDeviceCode($deviceCode);
        
        $this->assertSame($deviceCode, $this->entity->getDeviceCode());
    }

    public function test_deviceCode_setter_with_null(): void
    {
        $this->entity->setDeviceCode(null);
        $this->assertNull($this->entity->getDeviceCode());
    }

    public function test_createTime_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getCreateTime());

        $createTime = new \DateTime('2024-01-01 10:00:00');
        $this->entity->setCreateTime($createTime);
        
        $this->assertSame($createTime, $this->entity->getCreateTime());
    }

    public function test_createTime_setter_with_null(): void
    {
        $this->entity->setCreateTime(null);
        $this->assertNull($this->entity->getCreateTime());
    }

    public function test_updateTime_getter_and_setter(): void
    {
        $this->assertNull($this->entity->getUpdateTime());

        $updateTime = new \DateTime('2024-01-01 11:00:00');
        $this->entity->setUpdateTime($updateTime);
        
        $this->assertSame($updateTime, $this->entity->getUpdateTime());
    }

    public function test_updateTime_setter_with_null(): void
    {
        $this->entity->setUpdateTime(null);
        $this->assertNull($this->entity->getUpdateTime());
    }

    public function test_entity_with_all_properties_set(): void
    {
        $time = new \DateTime('2024-01-01 12:00:00');
        $createTime = new \DateTime('2024-01-01 10:00:00');
        $updateTime = new \DateTime('2024-01-01 11:00:00');
        
        $this->entity->setTime($time);
        $this->entity->setUserid('user123');
        $this->entity->setExternalUser('external456');
        $this->entity->setOperation('download');
        $this->entity->setFileInfo('document.pdf');
        $this->entity->setFileMd5('abc123');
        $this->entity->setFileSize('1024');
        $this->entity->setApplicantName('张三');
        $this->entity->setDeviceType(FileOperateDeviceCodeEnum::FIRM);
        $this->entity->setDeviceCode('device001');
        $this->entity->setCreateTime($createTime);
        $this->entity->setUpdateTime($updateTime);

        $this->assertSame($time, $this->entity->getTime());
        $this->assertSame('user123', $this->entity->getUserid());
        $this->assertSame('external456', $this->entity->getExternalUser());
        $this->assertSame('download', $this->entity->getOperation());
        $this->assertSame('document.pdf', $this->entity->getFileInfo());
        $this->assertSame('abc123', $this->entity->getFileMd5());
        $this->assertSame('1024', $this->entity->getFileSize());
        $this->assertSame('张三', $this->entity->getApplicantName());
        $this->assertSame(FileOperateDeviceCodeEnum::FIRM, $this->entity->getDeviceType());
        $this->assertSame('device001', $this->entity->getDeviceCode());
        $this->assertSame($createTime, $this->entity->getCreateTime());
        $this->assertSame($updateTime, $this->entity->getUpdateTime());
    }
} 