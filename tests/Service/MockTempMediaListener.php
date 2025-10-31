<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Service;

use WechatWorkMediaBundle\Entity\TempMedia;

/**
 * Mock TempMediaListener 用于测试环境，防止跨 Bundle 实体监听器依赖问题
 */
class MockTempMediaListener
{
    /**
     * Mock prePersist 处理器，生成测试用的 media ID，避免外部 API 调用
     */
    public function prePersist(TempMedia $media): void
    {
        // 为测试生成 mock media ID
        $mediaId = $media->getMediaId();
        if ('' === $mediaId) {
            $media->setMediaId('test_media_id_' . uniqid());
        }
    }
}
