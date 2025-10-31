<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use WechatWorkSecurityBundle\Entity\MemberOperateRecord;

/**
 * 企业微信成员操作记录管理控制器
 * @phpstan-extends AbstractCrudController<MemberOperateRecord>
 */
#[AdminCrud(routePath: '/wechat-work-security/member-operate-record', routeName: 'wechat_work_security_member_operate_record')]
final class MemberOperateRecordCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MemberOperateRecord::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('成员操作记录')
            ->setEntityLabelInPlural('成员操作记录管理')
            ->setSearchFields(['userid', 'operType', 'detailInfo', 'ip'])
            ->setDefaultSort(['time' => 'DESC'])
            ->setPaginatorPageSize(30)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),

            DateTimeField::new('time', '操作时间')
                ->setRequired(false)
                ->setFormat('yyyy-MM-dd HH:mm:ss')
                ->setHelp('成员操作发生的时间'),

            TextField::new('userid', '操作者用户ID')
                ->setRequired(false)
                ->setHelp('操作者的userid')
                ->setMaxLength(60),

            TextField::new('operType', '操作类型')
                ->setRequired(false)
                ->setHelp('成员执行的操作类型')
                ->setMaxLength(60),

            TextField::new('detailInfo', '相关数据')
                ->setRequired(false)
                ->setHelp('操作相关的详细数据信息')
                ->setMaxLength(60),

            TextField::new('ip', '操作者IP')
                ->setRequired(false)
                ->setHelp('操作者的IP地址')
                ->setMaxLength(60),

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
            ->add(DateTimeFilter::new('time', '操作时间'))
            ->add(TextFilter::new('userid', '操作者用户ID'))
            ->add(TextFilter::new('operType', '操作类型'))
            ->add(TextFilter::new('detailInfo', '相关数据'))
            ->add(TextFilter::new('ip', '操作者IP'))
            ->add(DateTimeFilter::new('createTime', '创建时间'))
            ->add(DateTimeFilter::new('updateTime', '更新时间'))
        ;
    }
}
