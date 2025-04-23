<?php

namespace WechatWorkSecurityBundle\Enum;

use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\ItemTrait;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\EnumExtra\SelectTrait;

/**
 * 设备来源
 */
enum TrustDeviceSourceEnum: int implements Labelable, Itemable, Selectable
{
    use ItemTrait;
    use SelectTrait;

    case UNKNOWN = 1;
    case MEMBER_CONFIRMATION = 2;
    case ADMIN_IMPORT = 3;
    case MEMBER_SELF_DECLARATION = 4;

    public function getLabel(): string
    {
        return match ($this) {
            self::UNKNOWN => '未知',
            self::MEMBER_CONFIRMATION => '成员确认',
            self::ADMIN_IMPORT => '管理员导入',
            self::MEMBER_SELF_DECLARATION => '成员自主申报',
        };
    }
}
