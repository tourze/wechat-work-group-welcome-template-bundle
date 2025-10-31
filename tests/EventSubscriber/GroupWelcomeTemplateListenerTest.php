<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\EventSubscriber;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Tourze\WechatWorkContracts\AgentInterface;
use WechatWorkBundle\Service\WorkService;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;
use WechatWorkGroupWelcomeTemplateBundle\EventSubscriber\GroupWelcomeTemplateListener;

/**
 * 单元测试：通过Mock依赖来测试EventSubscriber逻辑
 * 使用TestCase而非AbstractIntegrationTestCase是合理的选择，因为我们关注的是业务逻辑而非依赖注入
 *
 * @internal
 * @phpstan-ignore-next-line integrationTest.shouldUseAbstractIntegrationTestCase
 */
#[CoversClass(GroupWelcomeTemplateListener::class)]
final class GroupWelcomeTemplateListenerTest extends TestCase
{
    public function testPrePersistWithSyncFalseSkipsRemoteCreation(): void
    {
        $mockWorkService = $this->createMock(WorkService::class);
        $mockLogger = $this->createMock(LoggerInterface::class);
        $listener = new GroupWelcomeTemplateListener($mockWorkService, $mockLogger);

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
        $mockWorkService = $this->createMock(WorkService::class);
        $mockWorkService->method('request')->willReturn([
            'errcode' => 0,
            'errmsg' => 'ok',
            'template_id' => 'mock-template-id-' . uniqid(),
        ]);
        $mockLogger = $this->createMock(LoggerInterface::class);
        $listener = new GroupWelcomeTemplateListener($mockWorkService, $mockLogger);

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
        $this->assertStringStartsWith('mock-template-id-', $template->getTemplateId());
    }

    public function testPreUpdateWithSyncTrueAndNoTemplateIdCreatesRemote(): void
    {
        $mockWorkService = $this->createMock(WorkService::class);
        $mockWorkService->method('request')->willReturn([
            'errcode' => 0,
            'errmsg' => 'ok',
            'template_id' => 'mock-template-id-' . uniqid(),
        ]);
        $mockLogger = $this->createMock(LoggerInterface::class);
        $listener = new GroupWelcomeTemplateListener($mockWorkService, $mockLogger);

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
        $this->assertStringStartsWith('mock-template-id-', $template->getTemplateId());
    }

    public function testPreUpdateWithSyncTrueAndExistingTemplateIdUpdatesRemote(): void
    {
        $mockWorkService = $this->createMock(WorkService::class);
        $mockWorkService->method('request')->willReturn([
            'errcode' => 0,
            'errmsg' => 'ok',
        ]);
        $mockLogger = $this->createMock(LoggerInterface::class);
        $listener = new GroupWelcomeTemplateListener($mockWorkService, $mockLogger);

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
        $mockWorkService = $this->createMock(WorkService::class);
        // 配置Mock抛出异常来测试异常处理
        $mockWorkService->method('request')->willThrowException(new \Exception('API Error'));
        $mockLogger = $this->createMock(LoggerInterface::class);
        $listener = new GroupWelcomeTemplateListener($mockWorkService, $mockLogger);

        $template = new GroupWelcomeTemplate();
        $template->setTemplateId('invalid-template-id');
        $template->setAgent(null); // 这会导致请求失败

        // 即使请求失败，也不应该抛出异常
        $listener->postRemove($template);

        $this->assertSame('invalid-template-id', $template->getTemplateId());
    }
}
