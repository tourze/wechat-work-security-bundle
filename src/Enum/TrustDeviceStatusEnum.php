<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Enum;

use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\ItemTrait;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\EnumExtra\SelectTrait;

/**
 * 设备状态
 */
enum TrustDeviceStatusEnum: int implements Labelable, Itemable, Selectable
{
    use SelectTrait;
    use ItemTrait;

    case IMPORTED_BUT_NOT_LOGGED_IN = 1;
    case PENDING_INVITATION = 2;
    case PENDING_ADMIN_CONFIRMATION_AS_ENTERPRISE_DEVICE = 3;
    case PENDING_ADMIN_CONFIRMATION_AS_PERSONAL_DEVICE = 4;
    case CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE = 5;
    case CONFIRMED_AS_TRUSTED_PERSONAL_DEVICE = 6;

    public function getLabel(): string
    {
        return match ($this) {
            self::IMPORTED_BUT_NOT_LOGGED_IN => '已导入未登录',
            self::PENDING_INVITATION => '待邀请',
            self::PENDING_ADMIN_CONFIRMATION_AS_ENTERPRISE_DEVICE => '待管理员确认为企业设备',
            self::PENDING_ADMIN_CONFIRMATION_AS_PERSONAL_DEVICE => '待管理员确认为个人设备',
            self::CONFIRMED_AS_TRUSTED_ENTERPRISE_DEVICE => '已确认为可信企业设备',
            self::CONFIRMED_AS_TRUSTED_PERSONAL_DEVICE => '已确认为可信个人设备',
        };
    }
}
