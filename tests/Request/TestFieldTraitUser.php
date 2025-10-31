<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Request;

use WechatWorkBundle\Request\AgentAware;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;
use WechatWorkGroupWelcomeTemplateBundle\Request\FieldTrait;

/**
 * 用于测试 FieldTrait 的测试类
 */
class TestFieldTraitUser
{
    use FieldTrait;
    use AgentAware;

    // Make populateFromEntity accessible for testing
    public function publicPopulateFromEntity(GroupWelcomeTemplate $template): void
    {
        $this->populateFromEntity($template);
    }
}
