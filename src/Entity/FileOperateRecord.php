<?php

namespace WechatWorkSecurityBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use WechatWorkSecurityBundle\Enum\FileOperateDeviceCodeEnum;
use WechatWorkSecurityBundle\Repository\FileOperateRecordRepository;

/**
 * @see https://developer.work.weixin.qq.com/document/path/98079
 */

#[ORM\Entity(repositoryClass: FileOperateRecordRepository::class)]
#[ORM\Table(name: 'wechat_work_file_operate_record', options: ['comment' => '文件防泄漏'])]
class FileOperateRecord implements \Stringable
{
    use TimestampableAware;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['comment' => 'ID'])]
    private ?int $id = 0;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true, options: ['comment' => '操作时间'])]
    private ?\DateTimeInterface $time = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '企业账号id'])]
    private ?string $userid = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '企业外部人员信息'])]
    private ?string $externalUser = null;

    #[ORM\Column(length: 80, nullable: true, options: ['comment' => 'operation'])]
    private ?string $operation = null;

    #[ORM\Column(length: 80, nullable: true, options: ['comment' => '文件操作说明'])]
    private ?string $fileInfo = null;

    #[ORM\Column(length: 80, nullable: true, options: ['comment' => '文件md5'])]
    private ?string $fileMd5 = null;

    #[ORM\Column(length: 80, nullable: true, options: ['comment' => '文件大小'])]
    private ?string $fileSize = null;

    #[ORM\Column(length: 80, nullable: true, options: ['comment' => '当记录操作类型为『通过下载申请』或者『拒绝下载申请』时，该字段表示申请人的名字'])]
    private ?string $applicantName = null;

    #[ORM\Column(length: 20, nullable: false, enumType: FileOperateDeviceCodeEnum::class, options: ['comment' => '设备类型'])]
    private ?FileOperateDeviceCodeEnum $deviceType = FileOperateDeviceCodeEnum::FIRM;

    #[ORM\Column(length: 80, nullable: true, options: ['comment' => '设备编码'])]
    private ?string $deviceCode = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeviceType(): ?FileOperateDeviceCodeEnum
    {
        return $this->deviceType;
    }

    public function setDeviceType(?FileOperateDeviceCodeEnum $deviceType): void
    {
        $this->deviceType = $deviceType;
    }

    public function getDeviceCode(): ?string
    {
        return $this->deviceCode;
    }

    public function setDeviceCode(?string $deviceCode): void
    {
        $this->deviceCode = $deviceCode;
    }

    public function getApplicantName(): ?string
    {
        return $this->applicantName;
    }

    public function setApplicantName(?string $applicantName): void
    {
        $this->applicantName = $applicantName;
    }

    public function getFileSize(): ?string
    {
        return $this->fileSize;
    }

    public function setFileSize(?string $fileSize): void
    {
        $this->fileSize = $fileSize;
    }

    public function getFileMd5(): ?string
    {
        return $this->fileMd5;
    }

    public function setFileMd5(?string $fileMd5): void
    {
        $this->fileMd5 = $fileMd5;
    }

    public function getFileInfo(): ?string
    {
        return $this->fileInfo;
    }

    public function setFileInfo(?string $fileInfo): void
    {
        $this->fileInfo = $fileInfo;
    }

    public function getOperation(): ?string
    {
        return $this->operation;
    }

    public function setOperation(?string $operation): void
    {
        $this->operation = $operation;
    }

    public function getExternalUser(): ?string
    {
        return $this->externalUser;
    }

    public function setExternalUser(?string $externalUser): void
    {
        $this->externalUser = $externalUser;
    }

    public function getUserid(): ?string
    {
        return $this->userid;
    }

    public function setUserid(?string $userid): void
    {
        $this->userid = $userid;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(?\DateTimeInterface $time): void
    {
        $this->time = $time;
    }
    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
