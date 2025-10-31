<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Service;

use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;
use Tourze\EasyAdminMenuBundle\Service\MenuProviderInterface;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;

#[Autoconfigure(public: true)]
readonly class AdminMenu implements MenuProviderInterface
{
    public function __construct(private LinkGeneratorInterface $linkGenerator)
    {
    }

    public function __invoke(ItemInterface $item): void
    {
        if (null === $item->getChild('企业微信')) {
            $item->addChild('企业微信');
        }

        $wechatWorkMenu = $item->getChild('企业微信');
        if (null !== $wechatWorkMenu) {
            $wechatWorkMenu
                ->addChild('群欢迎语模板')
                ->setUri($this->linkGenerator->getCurdListPage(GroupWelcomeTemplate::class))
                ->setAttribute('icon', 'fas fa-comments')
            ;
        }
    }
}
