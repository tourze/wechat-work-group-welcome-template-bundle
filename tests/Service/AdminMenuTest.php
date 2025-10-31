<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Service;

use Knp\Menu\ItemInterface;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\MockObject\MockObject;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminMenuTestCase;
use WechatWorkGroupWelcomeTemplateBundle\Service\AdminMenu;

/**
 * AdminMenu 单元测试
 *
 * @internal
 */
#[CoversClass(AdminMenu::class)]
#[RunTestsInSeparateProcesses]
final class AdminMenuTest extends AbstractEasyAdminMenuTestCase
{
    /** @var ItemInterface&MockObject */
    private ItemInterface $item;

    public function testInvokeMethod(): void
    {
        // 测试 AdminMenu 的 __invoke 方法正常工作
        $adminMenu = self::getService(AdminMenu::class);

        // 设置期望：验证菜单方法被正确调用
        $this->item->expects(self::atLeastOnce())
            ->method('getChild')
            ->with('企业微信')
        ;

        // 验证调用不抛出异常
        ($adminMenu)($this->item);
    }

    protected function onSetUp(): void
    {
        $this->item = $this->createMock(ItemInterface::class);

        // 设置 mock 的返回值以避免 null 引用
        $childItem = $this->createMock(ItemInterface::class);
        $this->item->method('addChild')->willReturn($childItem);

        // 使用 willReturnCallback 来模拟 getChild 的行为
        $this->item->method('getChild')->willReturnCallback(function ($name) use ($childItem) {
            return '企业微信' === $name ? $childItem : null;
        });

        // 设置子菜单项的 mock 行为
        $childItem->method('addChild')->willReturn($childItem);
        $childItem->method('setUri')->willReturn($childItem);
        $childItem->method('setAttribute')->willReturn($childItem);
    }
}
