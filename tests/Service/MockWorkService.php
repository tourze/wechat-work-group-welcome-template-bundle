<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Service;

use HttpClientBundle\Request\RequestInterface;
use WechatWorkBundle\Service\WorkServiceInterface;
use WechatWorkGroupWelcomeTemplateBundle\Request\AddGroupWelcomeTemplateRequest;
use WechatWorkGroupWelcomeTemplateBundle\Request\DeleteGroupWelcomeTemplateRequest;
use WechatWorkGroupWelcomeTemplateBundle\Request\EditGroupWelcomeTemplateRequest;
use WechatWorkGroupWelcomeTemplateBundle\Request\GetGroupWelcomeTemplateRequest;

/**
 * Mock WorkService 实现，用于测试环境，避免真实的外部 API 调用
 */
class MockWorkService implements WorkServiceInterface
{
    public function request(RequestInterface $request): mixed
    {
        if ($request instanceof AddGroupWelcomeTemplateRequest) {
            return [
                'template_id' => 'mock_template_id_' . uniqid(),
                'errcode' => 0,
                'errmsg' => 'ok',
            ];
        }

        if ($request instanceof EditGroupWelcomeTemplateRequest) {
            return [
                'errcode' => 0,
                'errmsg' => 'ok',
            ];
        }

        if ($request instanceof DeleteGroupWelcomeTemplateRequest) {
            return [
                'errcode' => 0,
                'errmsg' => 'ok',
            ];
        }

        if ($request instanceof GetGroupWelcomeTemplateRequest) {
            return [
                'template' => [
                    'id' => $request->getTemplateId(),
                    'text' => [
                        'content' => 'Mock welcome message',
                    ],
                ],
                'errcode' => 0,
                'errmsg' => 'ok',
            ];
        }

        return [
            'errcode' => 0,
            'errmsg' => 'ok',
        ];
    }
}
