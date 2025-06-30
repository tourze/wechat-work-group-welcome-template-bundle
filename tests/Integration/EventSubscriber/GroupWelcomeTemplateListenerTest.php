<?php

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Integration\EventSubscriber;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Tourze\WechatWorkContracts\AgentInterface;
use WechatWorkBundle\Service\WorkService;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;
use WechatWorkGroupWelcomeTemplateBundle\EventSubscriber\GroupWelcomeTemplateListener;
use WechatWorkGroupWelcomeTemplateBundle\Request\AddGroupWelcomeTemplateRequest;
use WechatWorkGroupWelcomeTemplateBundle\Request\DeleteGroupWelcomeTemplateRequest;
use WechatWorkGroupWelcomeTemplateBundle\Request\EditGroupWelcomeTemplateRequest;

class GroupWelcomeTemplateListenerTest extends TestCase
{
    private GroupWelcomeTemplateListener $listener;
    /** @var WorkService&MockObject */
    private MockObject $workService;
    /** @var LoggerInterface&MockObject */
    private MockObject $logger;

    protected function setUp(): void
    {
        $this->workService = $this->createMock(WorkService::class);
        $this->logger = $this->createMock(LoggerInterface::class);
        $this->listener = new GroupWelcomeTemplateListener(
            $this->workService,
            $this->logger
        );
    }

    public function test_prePersist_withSyncTrue_createsRemoteTemplate(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setSync(true);
        $template->setTextContent('Welcome message');

        $expectedTemplateId = 'remote_template_123';

        $this->workService
            ->expects($this->once())
            ->method('request')
            ->with($this->isInstanceOf(AddGroupWelcomeTemplateRequest::class))
            ->willReturn(['template_id' => $expectedTemplateId]);

        $this->listener->prePersist($template);

        $this->assertSame($expectedTemplateId, $template->getTemplateId());
    }

    public function test_prePersist_withSyncFalse_skipsRemoteCreation(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setSync(false);

        $this->workService
            ->expects($this->never())
            ->method('request');

        $this->listener->prePersist($template);

        $this->assertNull($template->getTemplateId());
    }

    public function test_preUpdate_withSyncTrueAndTemplateId_updatesRemoteTemplate(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setSync(true);
        $template->setTemplateId('existing_template_123');
        $template->setTextContent('Updated message');

        $this->workService
            ->expects($this->once())
            ->method('request')
            ->with($this->callback(function ($request) {
                return $request instanceof EditGroupWelcomeTemplateRequest
                    && $request->getTemplateId() === 'existing_template_123';
            }));

        $this->listener->preUpdate($template);
    }

    public function test_preUpdate_withSyncTrueAndNoTemplateId_createsNewTemplate(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setSync(true);
        $template->setTemplateId(null);
        $template->setTextContent('New message');

        $expectedTemplateId = 'new_template_456';

        $this->workService
            ->expects($this->once())
            ->method('request')
            ->with($this->isInstanceOf(AddGroupWelcomeTemplateRequest::class))
            ->willReturn(['template_id' => $expectedTemplateId]);

        $this->listener->preUpdate($template);

        $this->assertSame($expectedTemplateId, $template->getTemplateId());
    }

    public function test_preUpdate_withSyncFalse_callsPostRemove(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setSync(false);
        $template->setTemplateId('template_to_delete');

        /** @var AgentInterface&MockObject $agent */
        $agent = $this->createMock(AgentInterface::class);
        $template->setAgent($agent);

        $this->workService
            ->expects($this->once())
            ->method('asyncRequest')
            ->with($this->callback(function ($request) {
                return $request instanceof DeleteGroupWelcomeTemplateRequest
                    && $request->getTemplateId() === 'template_to_delete';
            }));

        $this->listener->preUpdate($template);
    }

    public function test_postRemove_withTemplateId_deletesRemoteTemplate(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTemplateId('template_to_delete');

        /** @var AgentInterface&MockObject $agent */
        $agent = $this->createMock(AgentInterface::class);
        $template->setAgent($agent);

        $this->workService
            ->expects($this->once())
            ->method('asyncRequest')
            ->with($this->callback(function ($request) use ($agent) {
                return $request instanceof DeleteGroupWelcomeTemplateRequest
                    && $request->getTemplateId() === 'template_to_delete'
                    && $request->getAgent() === $agent;
            }));

        $this->listener->postRemove($template);
    }

    public function test_postRemove_withoutTemplateId_skipsRemoteDeletion(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTemplateId(null);

        $this->workService
            ->expects($this->never())
            ->method('asyncRequest');

        $this->listener->postRemove($template);
    }

    public function test_postRemove_withException_logsError(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setTemplateId('template_with_error');

        /** @var AgentInterface&MockObject $agent */
        $agent = $this->createMock(AgentInterface::class);
        $template->setAgent($agent);

        $exception = new \RuntimeException('Remote service error');

        $this->workService
            ->expects($this->once())
            ->method('asyncRequest')
            ->willThrowException($exception);

        $this->logger
            ->expects($this->once())
            ->method('error')
            ->with(
                '从远程删除入群欢迎语素材时发生异常',
                $this->callback(function ($context) use ($exception) {
                    return isset($context['exception']) && $context['exception'] === $exception;
                })
            );

        $this->listener->postRemove($template);
    }

    public function test_integration_fullLifecycle(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setSync(true);
        $template->setTextContent('Initial welcome message');

        /** @var AgentInterface&MockObject $agent */
        $agent = $this->createMock(AgentInterface::class);
        $template->setAgent($agent);

        // Step 1: Create
        $this->workService
            ->expects($this->exactly(2))
            ->method('request')
            ->willReturnOnConsecutiveCalls(
                ['template_id' => 'created_template_789'],
                true
            );

        $this->listener->prePersist($template);
        $this->assertSame('created_template_789', $template->getTemplateId());

        // Step 2: Update
        $template->setTextContent('Updated welcome message');
        $this->listener->preUpdate($template);

        // Step 3: Delete
        $this->workService
            ->expects($this->once())
            ->method('asyncRequest')
            ->with($this->isInstanceOf(DeleteGroupWelcomeTemplateRequest::class));

        $this->listener->postRemove($template);
    }
}