<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use WechatWorkBundle\DataFixtures\AgentFixtures;
use WechatWorkBundle\Entity\Agent;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;

class GroupWelcomeTemplateFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $agent = $this->getReference(AgentFixtures::AGENT_1_REFERENCE, Agent::class);

        // Create text-only welcome template
        $template1 = new GroupWelcomeTemplate();
        $template1->setAgent($agent);
        $template1->setTextContent('A welcome message');
        $template1->setSync(false);
        $template1->setTemplateId('test_template_1');
        $manager->persist($template1);

        // Create welcome template with image
        $template2 = new GroupWelcomeTemplate();
        $template2->setAgent($agent);
        $template2->setTextContent('B welcome message');
        $template2->setImagePicUrl('https://www.w3.org/Graphics/PNG/nurbcup2si.png');
        $template2->setSync(false);
        $template2->setTemplateId('test_template_2');
        $manager->persist($template2);

        // Create welcome template with link
        $template3 = new GroupWelcomeTemplate();
        $template3->setAgent($agent);
        $template3->setTextContent('C welcome message');
        $template3->setLinkTitle('新人指南');
        $template3->setLinkUrl('https://www.wikipedia.org/');
        $template3->setLinkDesc('快速了解团队文化和工作流程');
        $template3->setSync(false);
        $template3->setTemplateId('test_template_3');
        $manager->persist($template3);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AgentFixtures::class,
        ];
    }
}
