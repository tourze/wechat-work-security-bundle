<?php

namespace WechatWorkSecurityBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Tourze\DoctrineIndexedBundle\Attribute\IndexColumn;
use Tourze\DoctrineTimestampBundle\Attribute\CreateTimeColumn;
use Tourze\DoctrineTimestampBundle\Attribute\UpdateTimeColumn;
use Tourze\EasyAdmin\Attribute\Action\Exportable;
use Tourze\EasyAdmin\Attribute\Column\ExportColumn;
use Tourze\EasyAdmin\Attribute\Column\ListColumn;
use Tourze\EasyAdmin\Attribute\Filter\Filterable;
use Tourze\EasyAdmin\Attribute\Permission\AsPermission;
use WechatWorkSecurityBundle\Enum\ScreenShotTypeEnum;
use WechatWorkSecurityBundle\Repository\ScreenOperateRecordRepository;

/**
 * @see https://developer.work.weixin.qq.com/document/path/100128
 */
#[AsPermission(title: '截屏/录屏管理')]
#[Exportable]
#[ORM\Entity(repositoryClass: ScreenOperateRecordRepository::class)]
#[ORM\Table(name: 'wechat_work_screen_operate_record', options: ['comment' => '截屏/录屏管理'])]
class ScreenOperateRecord
{
    #[ListColumn(order: -1)]
    #[ExportColumn]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['comment' => 'ID'])]
    private ?int $id = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['comment' => '操作时间'])]
    private ?\DateTimeInterface $time = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '企业账号id'])]
    private ?string $userid = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '企业用户部门id'])]
    private ?int $departmentId = null;

    #[ORM\Column(length: 20, nullable: false, enumType: ScreenShotTypeEnum::class, options: ['comment' => '截屏内容类型'])]
    private ?ScreenShotTypeEnum $screenShotType;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '截屏内容'])]
    private ?string $screenShotContent = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '企业用户的操作系统'])]
    private ?string $system = null;

    #[Filterable]
    #[IndexColumn]
    #[ListColumn(order: 98, sorter: true)]
    #[ExportColumn]
    #[CreateTimeColumn]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['comment' => '创建时间'])]
    private ?\DateTimeInterface $createTime = null;

    #[UpdateTimeColumn]
    #[ListColumn(order: 99, sorter: true)]
    #[Filterable]
    #[ExportColumn]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['comment' => '更新时间'])]
    private ?\DateTimeInterface $updateTime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScreenShotType(): ?ScreenShotTypeEnum
    {
        return $this->screenShotType;
    }

    public function setScreenShotType(?ScreenShotTypeEnum $screenShotType): void
    {
        $this->screenShotType = $screenShotType;
    }

    public function getSystem(): ?string
    {
        return $this->system;
    }

    public function setSystem(?string $system): void
    {
        $this->system = $system;
    }

    public function getScreenShotContent(): ?string
    {
        return $this->screenShotContent;
    }

    public function setScreenShotContent(?string $screenShotContent): void
    {
        $this->screenShotContent = $screenShotContent;
    }

    public function getDepartmentId(): ?int
    {
        return $this->departmentId;
    }

    public function setDepartmentId(?int $departmentId): void
    {
        $this->departmentId = $departmentId;
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

    public function setCreateTime(?\DateTimeInterface $createdAt): void
    {
        $this->createTime = $createdAt;
    }

    public function getCreateTime(): ?\DateTimeInterface
    {
        return $this->createTime;
    }

    public function setUpdateTime(?\DateTimeInterface $updateTime): void
    {
        $this->updateTime = $updateTime;
    }

    public function getUpdateTime(): ?\DateTimeInterface
    {
        return $this->updateTime;
    }
}
