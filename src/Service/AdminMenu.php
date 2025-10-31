<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Service;

use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;
use Tourze\EasyAdminMenuBundle\Service\MenuProviderInterface;
use WechatWorkSecurityBundle\Entity\FileOperateRecord;
use WechatWorkSecurityBundle\Entity\MemberOperateRecord;
use WechatWorkSecurityBundle\Entity\ScreenOperateRecord;
use WechatWorkSecurityBundle\Entity\TrustDevice;

/**
 * 企业微信安全管控后台菜单提供者
 */
#[Autoconfigure(public: true)]
readonly class AdminMenu implements MenuProviderInterface
{
    public function __construct(
        private LinkGeneratorInterface $linkGenerator,
    ) {
    }

    public function __invoke(ItemInterface $item): void
    {
        if (null === $item->getChild('企业微信')) {
            $item->addChild('企业微信');
        }

        $wechatWorkMenu = $item->getChild('企业微信');
        if (null === $wechatWorkMenu) {
            return;
        }

        // 添加安全管控子菜单
        if (null === $wechatWorkMenu->getChild('安全管控')) {
            $wechatWorkMenu->addChild('安全管控')
                ->setAttribute('icon', 'fas fa-shield-alt')
            ;
        }

        $securityMenu = $wechatWorkMenu->getChild('安全管控');
        if (null === $securityMenu) {
            return;
        }

        $securityMenu->addChild('可信设备管理')
            ->setUri($this->linkGenerator->getCurdListPage(TrustDevice::class))
            ->setAttribute('icon', 'fas fa-laptop')
        ;

        $securityMenu->addChild('文件操作记录')
            ->setUri($this->linkGenerator->getCurdListPage(FileOperateRecord::class))
            ->setAttribute('icon', 'fas fa-file-shield')
        ;

        $securityMenu->addChild('成员操作记录')
            ->setUri($this->linkGenerator->getCurdListPage(MemberOperateRecord::class))
            ->setAttribute('icon', 'fas fa-user-shield')
        ;

        $securityMenu->addChild('截屏操作记录')
            ->setUri($this->linkGenerator->getCurdListPage(ScreenOperateRecord::class))
            ->setAttribute('icon', 'fas fa-camera')
        ;
    }
}
