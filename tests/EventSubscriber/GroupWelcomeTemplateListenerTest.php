<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\EventSubscriber;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;
use Tourze\WechatWorkContracts\AgentInterface;
use WechatWorkBundle\Service\WorkServiceInterface;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;
use WechatWorkGroupWelcomeTemplateBundle\EventSubscriber\GroupWelcomeTemplateListener;
use WechatWorkGroupWelcomeTemplateBundle\Tests\Service\MockWorkService;

#[CoversClass(GroupWelcomeTemplateListener::class)]
#[RunTestsInSeparateProcesses]
final class GroupWelcomeTemplateListenerTest extends AbstractIntegrationTestCase
{
    protected function onSetUp(): void
    {
        // 注册 MockWorkService 服务，替换真实的 WorkService
        static::getContainer()->set(WorkServiceInterface::class, new MockWorkService());
    }
    public function testPrePersistWithSyncFalseSkipsRemoteCreation(): void
    {
        $listener = self::getService(GroupWelcomeTemplateListener::class);

        $template = new GroupWelcomeTemplate();
        $agent = $this->createMock(AgentInterface::class);
        $agent->method('getAgentId')->willReturn('test-agent-id');
        $template->setAgent($agent);
        $template->setSync(false);

        $listener->prePersist($template);

        $this->assertNull($template->getTemplateId());
    }

    public function testPrePersistWithSyncTrueCreatesRemoteTemplate(): void
    {
        $listener = self::getService(GroupWelcomeTemplateListener::class);

        $template = new GroupWelcomeTemplate();
        $agent = $this->createMock(AgentInterface::class);
        $agent->method('getAgentId')->willReturn('test-agent-id');
        $template->setAgent($agent);
        $template->setSync(true);
        $template->setTextContent('Test welcome message');

        $listener->prePersist($template);

        // 验证远程创建后模板ID被设置
        $this->assertNotNull($template->getTemplateId());
        $this->assertIsString($template->getTemplateId());
        $this->assertStringStartsWith('mock_template_id_', $template->getTemplateId());
    }

    public function testPreUpdateWithSyncTrueAndNoTemplateIdCreatesRemote(): void
    {
        $listener = self::getService(GroupWelcomeTemplateListener::class);

        $template = new GroupWelcomeTemplate();
        $agent = $this->createMock(AgentInterface::class);
        $agent->method('getAgentId')->willReturn('test-agent-id');
        $template->setAgent($agent);
        $template->setSync(true);
        $template->setTemplateId(null);
        $template->setTextContent('Updated welcome message');

        $listener->preUpdate($template);

        // 没有模板ID时应该创建新的远程模板
        $this->assertNotNull($template->getTemplateId());
        $this->assertIsString($template->getTemplateId());
        $this->assertStringStartsWith('mock_template_id_', $template->getTemplateId());
    }

    public function testPreUpdateWithSyncTrueAndExistingTemplateIdUpdatesRemote(): void
    {
        $listener = self::getService(GroupWelcomeTemplateListener::class);

        $template = new GroupWelcomeTemplate();
        $agent = $this->createMock(AgentInterface::class);
        $agent->method('getAgentId')->willReturn('test-agent-id');
        $template->setAgent($agent);
        $template->setSync(true);
        $template->setTemplateId('existing-template-id');
        $template->setTextContent('Updated welcome message');

        $originalTemplateId = $template->getTemplateId();
        $listener->preUpdate($template);

        // 有模板ID时应该更新远程模板，ID保持不变
        $this->assertSame($originalTemplateId, $template->getTemplateId());
    }

    public function testPostRemoveHandlesExceptionsGracefully(): void
    {
        $listener = self::getService(GroupWelcomeTemplateListener::class);

        $template = new GroupWelcomeTemplate();
        $template->setTemplateId('invalid-template-id');
        $template->setAgent(null); // 这会导致请求失败

        // 即使请求失败，也不应该抛出异常
        $listener->postRemove($template);

        $this->assertSame('invalid-template-id', $template->getTemplateId());
    }
}
