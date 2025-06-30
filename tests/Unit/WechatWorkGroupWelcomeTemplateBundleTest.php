<?php

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use WechatWorkGroupWelcomeTemplateBundle\WechatWorkGroupWelcomeTemplateBundle;

class WechatWorkGroupWelcomeTemplateBundleTest extends TestCase
{
    private WechatWorkGroupWelcomeTemplateBundle $bundle;

    protected function setUp(): void
    {
        $this->bundle = new WechatWorkGroupWelcomeTemplateBundle();
    }

    public function test_bundle_extendsSymfonyBundle(): void
    {
        $this->assertInstanceOf(Bundle::class, $this->bundle);
    }

    public function test_bundle_getName(): void
    {
        $this->assertSame('WechatWorkGroupWelcomeTemplateBundle', $this->bundle->getName());
    }

    public function test_bundle_getPath(): void
    {
        $path = $this->bundle->getPath();
        
        $this->assertStringContainsString('wechat-work-group-welcome-template-bundle', $path);
    }
}