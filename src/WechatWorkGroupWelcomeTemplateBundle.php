<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\BundleDependency\BundleDependencyInterface;
use WechatWorkBundle\WechatWorkBundle;
use WechatWorkMediaBundle\WechatWorkMediaBundle;
use Tourze\EasyAdminMenuBundle\EasyAdminMenuBundle;

class WechatWorkGroupWelcomeTemplateBundle extends Bundle implements BundleDependencyInterface
{
    public static function getBundleDependencies(): array
    {
        return [
            DoctrineBundle::class => ['all' => true],
            WechatWorkBundle::class => ['all' => true],
            WechatWorkMediaBundle::class => ['all' => true],
            EasyAdminMenuBundle::class => ['all' => true],
        ];
    }
}
