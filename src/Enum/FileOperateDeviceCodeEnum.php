<?php

namespace WechatWorkSecurityBundle\Enum;

use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\ItemTrait;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\EnumExtra\SelectTrait;

/**
 * 设备类型
 */
enum FileOperateDeviceCodeEnum: int implements Labelable, Itemable, Selectable
{
    use ItemTrait;
    use SelectTrait;

    case FIRM = 1;
    case PERSONAGE = 2;

    public function getLabel(): string
    {
        return match ($this) {
            self::FIRM => '企业可信设备',
            self::PERSONAGE => '个人可信设备',
        };
    }
}
