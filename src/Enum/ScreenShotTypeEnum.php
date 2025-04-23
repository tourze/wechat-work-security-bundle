<?php

namespace WechatWorkSecurityBundle\Enum;

use Tourze\EnumExtra\Itemable;
use Tourze\EnumExtra\ItemTrait;
use Tourze\EnumExtra\Labelable;
use Tourze\EnumExtra\Selectable;
use Tourze\EnumExtra\SelectTrait;

/**
 * 截屏内容类型
 */
enum ScreenShotTypeEnum: int implements Labelable, Itemable, Selectable
{
    use ItemTrait;
    use SelectTrait;

    case CHAT = 1;
    case CONTACTS = 2;
    case MAIL = 3;
    case FILES = 4;
    case SCHEDULE = 5;
    case OTHERS = 6;

    public function getLabel(): string
    {
        return match ($this) {
            self::CHAT => '聊天',
            self::CONTACTS => '通讯录',
            self::MAIL => '邮箱',
            self::FILES => '文件',
            self::OTHERS => '其他',
        };
    }
}
