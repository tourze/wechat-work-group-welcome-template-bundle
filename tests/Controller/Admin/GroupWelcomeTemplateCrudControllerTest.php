<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminControllerTestCase;
use WechatWorkGroupWelcomeTemplateBundle\Controller\Admin\GroupWelcomeTemplateCrudController;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;

/**
 * 群欢迎语模板管理控制器测试
 * @internal
 */
#[CoversClass(GroupWelcomeTemplateCrudController::class)]
#[RunTestsInSeparateProcesses]
class GroupWelcomeTemplateCrudControllerTest extends AbstractEasyAdminControllerTestCase
{
    protected function getControllerService(): GroupWelcomeTemplateCrudController
    {
        return self::getService(GroupWelcomeTemplateCrudController::class);
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideIndexPageHeaders(): iterable
    {
        return [
            'id' => ['ID'],
            'agent' => ['应用代理'],
            'templateId' => ['模板ID'],
            'notify' => ['通知成员'],
            'textContent' => ['文本内容'],
            'imageMedia' => ['图片媒体'],
            'imagePicUrl' => ['图片链接'],
            'linkTitle' => ['链接标题'],
            'linkPicUrl' => ['链接图片'],
            'linkDesc' => ['链接描述'],
            'linkUrl' => ['链接地址'],
            'miniprogramTitle' => ['小程序标题'],
            'miniprogramMedia' => ['小程序图片'],
            'miniprogramAppId' => ['小程序AppID'],
            'miniprogramPage' => ['小程序页面'],
            'fileMedia' => ['文件媒体'],
            'videoMedia' => ['视频媒体'],
            'sync' => ['已同步'],
            'createTime' => ['创建时间'],
            'updateTime' => ['更新时间'],
            'createdBy' => ['创建者'],
            'updatedBy' => ['更新者'],
        ];
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideNewPageFields(): iterable
    {
        return [
            'agent' => ['agent'],
            'notify' => ['notify'],
            'textContent' => ['textContent'],
            'imageMedia' => ['imageMedia'],
            'imagePicUrl' => ['imagePicUrl'],
            'linkTitle' => ['linkTitle'],
            'linkPicUrl' => ['linkPicUrl'],
            'linkDesc' => ['linkDesc'],
            'linkUrl' => ['linkUrl'],
            'miniprogramTitle' => ['miniprogramTitle'],
            'miniprogramMedia' => ['miniprogramMedia'],
            'miniprogramAppId' => ['miniprogramAppId'],
            'miniprogramPage' => ['miniprogramPage'],
            'fileMedia' => ['fileMedia'],
            'videoMedia' => ['videoMedia'],
        ];
    }

    /**
     * @return iterable<string, array{string}>
     */
    public static function provideEditPageFields(): iterable
    {
        return [
            'agent' => ['agent'],
            'notify' => ['notify'],
            'textContent' => ['textContent'],
            'imageMedia' => ['imageMedia'],
            'imagePicUrl' => ['imagePicUrl'],
            'linkTitle' => ['linkTitle'],
            'linkPicUrl' => ['linkPicUrl'],
            'linkDesc' => ['linkDesc'],
            'linkUrl' => ['linkUrl'],
            'miniprogramTitle' => ['miniprogramTitle'],
            'miniprogramMedia' => ['miniprogramMedia'],
            'miniprogramAppId' => ['miniprogramAppId'],
            'miniprogramPage' => ['miniprogramPage'],
            'fileMedia' => ['fileMedia'],
            'videoMedia' => ['videoMedia'],
        ];
    }

    public function testConfigureFields(): void
    {
        $controller = $this->getControllerService();
        $fields = $controller->configureFields('index');

        // 将 Generator 转换为数组进行断言
        $fieldsArray = iterator_to_array($fields);
        self::assertNotEmpty($fieldsArray);
    }

    public function testConfigureCrud(): void
    {
        $controller = $this->getControllerService();
        $result = $controller->configureCrud(Crud::new());

        // 验证基本配置
        $dto = $result->getAsDto();
        self::assertSame('群欢迎语模板', $dto->getEntityLabelInSingular());
        self::assertSame('群欢迎语模板', $dto->getEntityLabelInPlural());
        self::assertSame(20, $dto->getPaginator()->getPageSize());
        self::assertSame(['id' => 'DESC'], $dto->getDefaultSort());
    }

    public function testConfigureFilters(): void
    {
        $controller = $this->getControllerService();
        $result = $controller->configureFilters(Filters::new());

        // 验证配置了多个过滤器
        $dto = $result->getAsDto();
        $filters = $dto->all();
        self::assertCount(7, $filters, 'Should have 7 filters configured');
        self::assertNotNull($dto->getFilter('agent'));
        self::assertNotNull($dto->getFilter('templateId'));
        self::assertNotNull($dto->getFilter('textContent'));
    }

    public function testConfigureActions(): void
    {
        $controller = $this->getControllerService();
        $result = $controller->configureActions(Actions::new());

        // 验证索引页的 actions 配置
        $indexActions = $result->getAsDto(Crud::PAGE_INDEX);
        $actions = $indexActions->getActions();
        self::assertGreaterThan(0, count($actions), 'Index page should have at least one action configured');

        // 验证添加了 DETAIL action
        $detailAction = is_array($actions) ? ($actions['detail'] ?? null) : $actions->get('detail');
        self::assertNotNull($detailAction, 'Index page should have detail action');
    }
}
