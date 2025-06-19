<?php

namespace WechatWorkSecurityBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use Tourze\EasyAdmin\Attribute\Action\Exportable;
use WechatWorkSecurityBundle\Repository\MemberOperateRecordRepository;

/**
 * @see https://developer.work.weixin.qq.com/document/path/100178
 */
#[Exportable]
#[ORM\Entity(repositoryClass: MemberOperateRecordRepository::class)]
#[ORM\Table(name: 'wechat_work_member_operate_record', options: ['comment' => '获取成员操作记录'])]
class MemberOperateRecord implements \Stringable
{
    use TimestampableAware;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['comment' => 'ID'])]
    private ?int $id = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['comment' => '操作时间'])]
    private ?\DateTimeInterface $time = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '操作者userid'])]
    private ?string $userid = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '操作类型'])]
    private ?string $operType = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '相关数据'])]
    private ?string $detailInfo = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '	操作者ip'])]
    private ?string $ip = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIp(): ?string
    {
        return $this->ip;
    }

    public function setIp(?string $ip): void
    {
        $this->ip = $ip;
    }

    public function getDetailInfo(): ?string
    {
        return $this->detailInfo;
    }

    public function setDetailInfo(?string $detailInfo): void
    {
        $this->detailInfo = $detailInfo;
    }

    public function getOperType(): ?string
    {
        return $this->operType;
    }

    public function setOperType(?string $operType): void
    {
        $this->operType = $operType;
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
