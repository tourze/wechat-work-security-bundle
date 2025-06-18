<?php

namespace WechatWorkSecurityBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use Tourze\EasyAdmin\Attribute\Action\Exportable;
use WechatWorkSecurityBundle\Enum\TrustDeviceSourceEnum;
use WechatWorkSecurityBundle\Enum\TrustDeviceStatusEnum;
use WechatWorkSecurityBundle\Repository\TrustDeviceRepository;

/**
 * @see https://developer.work.weixin.qq.com/document/path/98920
 */
#[Exportable]
#[ORM\Entity(repositoryClass: TrustDeviceRepository::class)]
#[ORM\Table(name: 'wechat_work_trust_device', options: ['comment' => '获取设备信息'])]
class TrustDevice
{
    use TimestampableAware;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER, options: ['comment' => 'ID'])]
    private ?int $id = 0;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '查询设备类型'])]
    private ?string $type = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '设备编码'])]
    private ?string $deviceCode = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '系统'])]
    private ?string $system = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '设备MAC地址'])]
    private ?string $macAddr = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '主板UUID'])]
    private ?string $motherboardUuid = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '硬盘UUID'])]
    private ?string $harddiskUuid = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => 'Windows域'])]
    private ?string $domain = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '计算机名'])]
    private ?string $pcName = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => 'Mac序列号'])]
    private ?string $seqNo = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '设备最后登录时间戳'])]
    private ?string $lastLoginTime = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '设备最后登录成员userid'])]
    private ?string $lastLoginUserid = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '设备归属/确认时间戳'])]
    private ?string $confirmTimestamp = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '设备归属/确认成员userid'])]
    private ?string $confirmUserid = null;

    #[ORM\Column(length: 60, nullable: true, options: ['comment' => '通过申报的管理员userid'])]
    private ?string $approvedUserid = null;

    #[ORM\Column(length: 20, nullable: false, enumType: TrustDeviceSourceEnum::class, options: ['comment' => '设备来源'])]
    private ?TrustDeviceSourceEnum $source = TrustDeviceSourceEnum::UNKNOWN;

    #[ORM\Column(length: 20, nullable: false, enumType: TrustDeviceStatusEnum::class, options: ['comment' => '设备来源'])]
    private ?TrustDeviceStatusEnum $status = TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?TrustDeviceStatusEnum
    {
        return $this->status;
    }

    public function setStatus(?TrustDeviceStatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getSource(): ?TrustDeviceSourceEnum
    {
        return $this->source;
    }

    public function setSource(?TrustDeviceSourceEnum $source): void
    {
        $this->source = $source;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    public function getApprovedUserid(): ?string
    {
        return $this->approvedUserid;
    }

    public function setApprovedUserid(?string $approvedUserid): void
    {
        $this->approvedUserid = $approvedUserid;
    }

    public function getConfirmUserid(): ?string
    {
        return $this->confirmUserid;
    }

    public function setConfirmUserid(?string $confirmUserid): void
    {
        $this->confirmUserid = $confirmUserid;
    }

    public function getConfirmTimestamp(): ?string
    {
        return $this->confirmTimestamp;
    }

    public function setConfirmTimestamp(?string $confirmTimestamp): void
    {
        $this->confirmTimestamp = $confirmTimestamp;
    }

    public function getLastLoginUserid(): ?string
    {
        return $this->lastLoginUserid;
    }

    public function setLastLoginUserid(?string $lastLoginUserid): void
    {
        $this->lastLoginUserid = $lastLoginUserid;
    }

    public function getLastLoginTime(): ?string
    {
        return $this->lastLoginTime;
    }

    public function setLastLoginTime(?string $lastLoginTime): void
    {
        $this->lastLoginTime = $lastLoginTime;
    }

    public function getSeqNo(): ?string
    {
        return $this->seqNo;
    }

    public function setSeqNo(?string $seqNo): void
    {
        $this->seqNo = $seqNo;
    }

    public function getPcName(): ?string
    {
        return $this->pcName;
    }

    public function setPcName(?string $pcName): void
    {
        $this->pcName = $pcName;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(?string $domain): void
    {
        $this->domain = $domain;
    }

    public function getHarddiskUuid(): ?string
    {
        return $this->harddiskUuid;
    }

    public function setHarddiskUuid(?string $harddiskUuid): void
    {
        $this->harddiskUuid = $harddiskUuid;
    }

    public function getMotherboardUuid(): ?string
    {
        return $this->motherboardUuid;
    }

    public function setMotherboardUuid(?string $motherboardUuid): void
    {
        $this->motherboardUuid = $motherboardUuid;
    }

    public function getMacAddr(): ?string
    {
        return $this->macAddr;
    }

    public function setMacAddr(?string $macAddr): void
    {
        $this->macAddr = $macAddr;
    }

    public function getSystem(): ?string
    {
        return $this->system;
    }

    public function setSystem(?string $system): void
    {
        $this->system = $system;
    }

    public function getDeviceCode(): ?string
    {
        return $this->deviceCode;
    }

    public function setDeviceCode(?string $deviceCode): void
    {
        $this->deviceCode = $deviceCode;
    }}
