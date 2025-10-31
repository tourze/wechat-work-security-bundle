<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use WechatWorkSecurityBundle\Entity\TrustDevice;
use WechatWorkSecurityBundle\Enum\TrustDeviceSourceEnum;
use WechatWorkSecurityBundle\Enum\TrustDeviceStatusEnum;

/**
 * 企业微信安全管控可信设备管理控制器
 * @extends AbstractCrudController<TrustDevice>
 */
#[AdminCrud(routePath: '/wechat-work-security/trust-device', routeName: 'wechat_work_security_trust_device')]
final class TrustDeviceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TrustDevice::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('可信设备')
            ->setEntityLabelInPlural('可信设备管理')
            ->setSearchFields(['deviceCode', 'pcName', 'macAddr', 'lastLoginUserid', 'confirmUserid'])
            ->setDefaultSort(['createTime' => 'DESC'])
            ->setPaginatorPageSize(30)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),

            TextField::new('type', '设备类型')
                ->setRequired(false)
                ->setHelp('查询设备类型')
                ->setMaxLength(60),

            TextField::new('deviceCode', '设备编码')
                ->setRequired(false)
                ->setHelp('设备唯一编码')
                ->setMaxLength(60),

            TextField::new('system', '操作系统')
                ->setRequired(false)
                ->setHelp('设备操作系统信息')
                ->setMaxLength(60),

            TextField::new('macAddr', 'MAC地址')
                ->setRequired(false)
                ->setHelp('设备MAC地址')
                ->setMaxLength(60),

            TextField::new('motherboardUuid', '主板UUID')
                ->setRequired(false)
                ->setHelp('设备主板唯一标识')
                ->setMaxLength(60),

            TextField::new('harddiskUuid', '硬盘UUID')
                ->setRequired(false)
                ->setHelp('设备硬盘唯一标识')
                ->setMaxLength(60),

            TextField::new('domain', 'Windows域')
                ->setRequired(false)
                ->setHelp('Windows域信息')
                ->setMaxLength(60),

            TextField::new('pcName', '计算机名')
                ->setRequired(false)
                ->setHelp('设备计算机名称')
                ->setMaxLength(60),

            TextField::new('seqNo', 'Mac序列号')
                ->setRequired(false)
                ->setHelp('Mac设备序列号')
                ->setMaxLength(60),

            TextField::new('lastLoginTime', '最后登录时间')
                ->setRequired(false)
                ->setHelp('设备最后登录时间戳')
                ->setMaxLength(60),

            TextField::new('lastLoginUserid', '最后登录用户')
                ->setRequired(false)
                ->setHelp('设备最后登录成员userid')
                ->setMaxLength(60),

            TextField::new('confirmTimestamp', '确认时间戳')
                ->setRequired(false)
                ->setHelp('设备归属/确认时间戳')
                ->setMaxLength(60),

            TextField::new('confirmUserid', '确认用户')
                ->setRequired(false)
                ->setHelp('设备归属/确认成员userid')
                ->setMaxLength(60),

            TextField::new('approvedUserid', '审批用户')
                ->setRequired(false)
                ->setHelp('通过申报的管理员userid')
                ->setMaxLength(60),

            ChoiceField::new('source', '设备来源')
                ->setRequired(true)
                ->setChoices(TrustDeviceSourceEnum::genOptions())
                ->setHelp('设备来源类型')
                ->setFormTypeOption('empty_data', TrustDeviceSourceEnum::UNKNOWN->value),

            ChoiceField::new('status', '设备状态')
                ->setRequired(true)
                ->setChoices(TrustDeviceStatusEnum::genOptions())
                ->setHelp('设备当前状态')
                ->setFormTypeOption('empty_data', TrustDeviceStatusEnum::IMPORTED_BUT_NOT_LOGGED_IN->value),

            DateTimeField::new('createTime', '创建时间')
                ->hideOnForm()
                ->setFormat('yyyy-MM-dd HH:mm:ss'),

            DateTimeField::new('updateTime', '更新时间')
                ->hideOnForm()
                ->setFormat('yyyy-MM-dd HH:mm:ss'),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(TextFilter::new('type', '设备类型'))
            ->add(TextFilter::new('deviceCode', '设备编码'))
            ->add(TextFilter::new('system', '操作系统'))
            ->add(TextFilter::new('macAddr', 'MAC地址'))
            ->add(TextFilter::new('pcName', '计算机名'))
            ->add(TextFilter::new('lastLoginUserid', '最后登录用户'))
            ->add(TextFilter::new('confirmUserid', '确认用户'))
            ->add(TextFilter::new('approvedUserid', '审批用户'))
            ->add(ChoiceFilter::new('source', '设备来源')->setChoices(TrustDeviceSourceEnum::genOptions()))
            ->add(ChoiceFilter::new('status', '设备状态')->setChoices(TrustDeviceStatusEnum::genOptions()))
            ->add(DateTimeFilter::new('createTime', '创建时间'))
            ->add(DateTimeFilter::new('updateTime', '更新时间'))
        ;
    }
}
