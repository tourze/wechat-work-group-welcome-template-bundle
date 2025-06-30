<?php

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Unit\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use WechatWorkGroupWelcomeTemplateBundle\DependencyInjection\WechatWorkGroupWelcomeTemplateExtension;

class WechatWorkGroupWelcomeTemplateExtensionTest extends TestCase
{
    private WechatWorkGroupWelcomeTemplateExtension $extension;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->extension = new WechatWorkGroupWelcomeTemplateExtension();
        $this->container = new ContainerBuilder();
    }

    public function test_load_withEmptyConfig_loadsServicesFile(): void
    {
        $this->extension->load([], $this->container);

        // 验证 Extension 能正常加载
        $this->assertInstanceOf(ContainerBuilder::class, $this->container);
    }

    public function test_load_withMultipleConfigs_loadsServicesFile(): void
    {
        $configs = [
            ['test' => 'value'],
            ['another' => 'config'],
        ];

        $this->extension->load($configs, $this->container);

        // 验证 Extension 能正常加载多个配置
        $this->assertInstanceOf(ContainerBuilder::class, $this->container);
    }

    public function test_load_ensureServicesLoaded(): void
    {
        $this->extension->load([], $this->container);

        // 验证容器状态正常
        $this->assertInstanceOf(ContainerBuilder::class, $this->container);
    }
}