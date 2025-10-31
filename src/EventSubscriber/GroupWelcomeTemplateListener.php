<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use WechatWorkBundle\Service\WorkService;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;
use WechatWorkGroupWelcomeTemplateBundle\Request\AddGroupWelcomeTemplateRequest;
use WechatWorkGroupWelcomeTemplateBundle\Request\DeleteGroupWelcomeTemplateRequest;
use WechatWorkGroupWelcomeTemplateBundle\Request\EditGroupWelcomeTemplateRequest;

#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: GroupWelcomeTemplate::class)]
#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: GroupWelcomeTemplate::class)]
#[AsEntityListener(event: Events::postRemove, method: 'postRemove', entity: GroupWelcomeTemplate::class)]
#[Autoconfigure(public: true)]
#[WithMonologChannel(channel: 'wechat_work_group_welcome_template')]
class GroupWelcomeTemplateListener
{
    public function __construct(
        private readonly WorkService $workService,
        private readonly LoggerInterface $logger,
    ) {
    }

    /**
     * 创建远程记录
     */
    public function prePersist(GroupWelcomeTemplate $template): void
    {
        if (true !== $template->isSync()) {
            return;
        }

        $request = AddGroupWelcomeTemplateRequest::createFromEntity($template);
        $res = $this->workService->request($request);

        if (!is_array($res) || !isset($res['template_id'])) {
            $this->logger->error('创建入群欢迎语模板失败：响应格式错误', [
                'template' => $template,
                'response' => $res,
            ]);

            return;
        }

        $templateId = $res['template_id'];
        if (!is_string($templateId)) {
            $this->logger->error('创建入群欢迎语模板失败：template_id类型错误', [
                'template' => $template,
                'template_id' => $templateId,
            ]);

            return;
        }

        $template->setTemplateId($templateId);
    }

    public function preUpdate(GroupWelcomeTemplate $template): void
    {
        if (true !== $template->isSync()) {
            $this->postRemove($template);

            return;
        }

        // 没模板ID的话，我们创建一次
        if (null === $template->getTemplateId()) {
            $this->prePersist($template);

            return;
        }

        $request = EditGroupWelcomeTemplateRequest::createFromEntity($template);
        $request->setTemplateId($template->getTemplateId());
        $this->workService->request($request);
    }

    /**
     * 从远程删除
     */
    public function postRemove(GroupWelcomeTemplate $template): void
    {
        if (null === $template->getTemplateId()) {
            return;
        }

        try {
            $request = new DeleteGroupWelcomeTemplateRequest();
            $request->setTemplateId($template->getTemplateId());
            $request->setAgent($template->getAgent());
            $this->workService->request($request);
        } catch (\Throwable $exception) {
            $this->logger->error('从远程删除入群欢迎语素材时发生异常', [
                'exception' => $exception,
            ]);
        }
    }
}
