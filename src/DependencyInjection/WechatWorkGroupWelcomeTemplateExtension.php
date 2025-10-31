<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\DependencyInjection;

use Tourze\SymfonyDependencyServiceLoader\AutoExtension;

class WechatWorkGroupWelcomeTemplateExtension extends AutoExtension
{
    protected function getConfigDir(): string
    {
        return __DIR__ . '/../Resources/config';
    }
}
