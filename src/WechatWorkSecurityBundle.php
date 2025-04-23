<?php

namespace WechatWorkSecurityBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\EasyAdmin\Attribute\Permission\AsPermission;

#[AsPermission(title: '安全管理')]
class WechatWorkSecurityBundle extends Bundle
{
}
