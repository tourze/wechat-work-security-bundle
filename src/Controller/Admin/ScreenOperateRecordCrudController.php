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
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\DateTimeFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\NumericFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use WechatWorkSecurityBundle\Entity\ScreenOperateRecord;
use WechatWorkSecurityBundle\Enum\ScreenShotTypeEnum;

/**
 * 企业微信截屏/录屏管理记录控制器
 * @extends AbstractCrudController<ScreenOperateRecord>
 */
#[AdminCrud(routePath: '/wechat-work-security/screen-operate-record', routeName: 'wechat_work_security_screen_operate_record')]
final class ScreenOperateRecordCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ScreenOperateRecord::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('截屏操作记录')
            ->setEntityLabelInPlural('截屏操作记录管理')
            ->setSearchFields(['userid', 'screenShotContent', 'system'])
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
                ->setHelp('截屏操作发生的时间'),

            TextField::new('userid', '企业账号ID')
                ->setRequired(false)
                ->setHelp('操作用户的企业账号id')
                ->setMaxLength(60),

            IntegerField::new('departmentId', '部门ID')
                ->setRequired(false)
                ->setHelp('企业用户部门id'),

            ChoiceField::new('screenShotType', '截屏内容类型')
                ->setRequired(true)
                ->setChoices(ScreenShotTypeEnum::genOptions())
                ->setHelp('截屏内容的类型')
                ->setFormTypeOption('empty_data', ScreenShotTypeEnum::OTHERS->value),

            TextField::new('screenShotContent', '截屏内容')
                ->setRequired(false)
                ->setHelp('截屏的具体内容信息')
                ->setMaxLength(60),

            TextField::new('system', '操作系统')
                ->setRequired(false)
                ->setHelp('企业用户的操作系统')
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
            ->add(TextFilter::new('userid', '企业账号ID'))
            ->add(NumericFilter::new('departmentId', '部门ID'))
            ->add(ChoiceFilter::new('screenShotType', '截屏内容类型')->setChoices(ScreenShotTypeEnum::genOptions()))
            ->add(TextFilter::new('screenShotContent', '截屏内容'))
            ->add(TextFilter::new('system', '操作系统'))
            ->add(DateTimeFilter::new('createTime', '创建时间'))
            ->add(DateTimeFilter::new('updateTime', '更新时间'))
        ;
    }
}
