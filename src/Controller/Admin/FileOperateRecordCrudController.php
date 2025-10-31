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
use WechatWorkSecurityBundle\Entity\FileOperateRecord;
use WechatWorkSecurityBundle\Enum\FileOperateDeviceCodeEnum;

/**
 * 企业微信文件防泄漏操作记录管理控制器
 * @extends AbstractCrudController<FileOperateRecord>
 */
#[AdminCrud(routePath: '/wechat-work-security/file-operate-record', routeName: 'wechat_work_security_file_operate_record')]
final class FileOperateRecordCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FileOperateRecord::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('文件操作记录')
            ->setEntityLabelInPlural('文件操作记录管理')
            ->setSearchFields(['userid', 'externalUser', 'operation', 'fileInfo', 'fileMd5', 'applicantName'])
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
                ->setHelp('文件操作发生的时间'),

            TextField::new('userid', '企业账号ID')
                ->setRequired(false)
                ->setHelp('操作用户的企业账号id')
                ->setMaxLength(60),

            TextField::new('externalUser', '外部人员信息')
                ->setRequired(false)
                ->setHelp('企业外部人员信息')
                ->setMaxLength(60),

            TextField::new('operation', '操作类型')
                ->setRequired(false)
                ->setHelp('文件操作类型说明')
                ->setMaxLength(80),

            TextField::new('fileInfo', '文件信息')
                ->setRequired(false)
                ->setHelp('文件操作说明信息')
                ->setMaxLength(80),

            TextField::new('fileMd5', '文件MD5')
                ->setRequired(false)
                ->setHelp('文件的MD5校验值')
                ->setMaxLength(80),

            TextField::new('fileSize', '文件大小')
                ->setRequired(false)
                ->setHelp('文件大小信息')
                ->setMaxLength(80),

            TextField::new('applicantName', '申请人姓名')
                ->setRequired(false)
                ->setHelp('当记录操作类型为『通过下载申请』或者『拒绝下载申请』时，该字段表示申请人的名字')
                ->setMaxLength(80),

            ChoiceField::new('deviceType', '设备类型')
                ->setRequired(true)
                ->setChoices(FileOperateDeviceCodeEnum::genOptions())
                ->setHelp('操作设备的类型')
                ->setFormTypeOption('empty_data', FileOperateDeviceCodeEnum::FIRM->value),

            TextField::new('deviceCode', '设备编码')
                ->setRequired(false)
                ->setHelp('设备唯一编码')
                ->setMaxLength(80),

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
            ->add(TextFilter::new('externalUser', '外部人员信息'))
            ->add(TextFilter::new('operation', '操作类型'))
            ->add(TextFilter::new('fileInfo', '文件信息'))
            ->add(TextFilter::new('fileMd5', '文件MD5'))
            ->add(TextFilter::new('applicantName', '申请人姓名'))
            ->add(ChoiceFilter::new('deviceType', '设备类型')->setChoices(FileOperateDeviceCodeEnum::genOptions()))
            ->add(TextFilter::new('deviceCode', '设备编码'))
            ->add(DateTimeFilter::new('createTime', '创建时间'))
            ->add(DateTimeFilter::new('updateTime', '更新时间'))
        ;
    }
}
