<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;

/**
 * @extends AbstractCrudController<GroupWelcomeTemplate>
 */
#[AdminCrud(routePath: '/group-welcome/template', routeName: 'group_welcome_template')]
final class GroupWelcomeTemplateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return GroupWelcomeTemplate::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('群欢迎语模板')
            ->setEntityLabelInPlural('群欢迎语模板')
            ->setPageTitle('index', '群欢迎语模板列表')
            ->setPageTitle('detail', '群欢迎语模板详情')
            ->setPageTitle('new', '新增群欢迎语模板')
            ->setPageTitle('edit', '编辑群欢迎语模板')
            ->setDefaultSort(['id' => 'DESC'])
            ->setPaginatorPageSize(20)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id', 'ID')->hideOnForm();

        yield AssociationField::new('agent', '应用代理')
            ->setHelp('选择企业微信应用代理')
        ;

        yield TextField::new('templateId', '模板ID')
            ->setMaxLength(120)
            ->setHelp('企业微信返回的欢迎语素材ID')
            ->hideOnForm()
        ;

        yield BooleanField::new('notify', '通知成员')
            ->setHelp('是否通知成员有新的入群欢迎语')
            ->renderAsSwitch()
        ;

        yield TextareaField::new('textContent', '文本内容')
            ->setMaxLength(65535)
            ->setHelp('欢迎语的文本内容，支持企业微信格式')
            ->setNumOfRows(4)
        ;

        // 图片相关字段
        yield AssociationField::new('imageMedia', '图片媒体')
            ->setHelp('选择上传的图片媒体文件')
        ;

        yield UrlField::new('imagePicUrl', '图片链接')
            ->setHelp('图片的URL地址')
        ;

        // 链接相关字段
        yield TextField::new('linkTitle', '链接标题')
            ->setMaxLength(128)
            ->setHelp('链接卡片的标题')
        ;

        yield UrlField::new('linkPicUrl', '链接图片')
            ->setHelp('链接卡片的图片URL')
        ;

        yield TextField::new('linkDesc', '链接描述')
            ->setMaxLength(512)
            ->setHelp('链接卡片的描述文字')
        ;

        yield UrlField::new('linkUrl', '链接地址')
            ->setHelp('链接的目标地址')
        ;

        // 小程序相关字段
        yield TextField::new('miniprogramTitle', '小程序标题')
            ->setMaxLength(64)
            ->setHelp('小程序卡片的标题')
        ;

        yield AssociationField::new('miniprogramMedia', '小程序图片')
            ->setHelp('小程序卡片的封面图片')
        ;

        yield TextField::new('miniprogramAppId', '小程序AppID')
            ->setMaxLength(64)
            ->setHelp('小程序的AppID')
        ;

        yield TextField::new('miniprogramPage', '小程序页面')
            ->setMaxLength(255)
            ->setHelp('小程序打开的页面路径')
        ;

        // 文件和视频
        yield AssociationField::new('fileMedia', '文件媒体')
            ->setHelp('选择文件类型的媒体')
        ;

        yield AssociationField::new('videoMedia', '视频媒体')
            ->setHelp('选择视频类型的媒体')
        ;

        yield BooleanField::new('sync', '已同步')
            ->setHelp('是否已同步到企业微信服务器')
            ->renderAsSwitch()
            ->hideOnForm()
        ;

        // 系统字段
        yield DateTimeField::new('createTime', '创建时间')
            ->hideOnForm()
            ->setFormat('yyyy-MM-dd HH:mm:ss')
        ;

        yield DateTimeField::new('updateTime', '更新时间')
            ->hideOnForm()
            ->setFormat('yyyy-MM-dd HH:mm:ss')
        ;

        yield TextField::new('createdBy', '创建者')
            ->hideOnForm()
        ;

        yield TextField::new('updatedBy', '更新者')
            ->hideOnForm()
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('agent', '应用代理'))
            ->add(TextFilter::new('templateId', '模板ID'))
            ->add(BooleanFilter::new('notify', '通知成员'))
            ->add(TextFilter::new('textContent', '文本内容'))
            ->add(TextFilter::new('linkTitle', '链接标题'))
            ->add(TextFilter::new('miniprogramTitle', '小程序标题'))
            ->add(BooleanFilter::new('sync', '已同步'))
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
        ;
    }
}
