<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Request;

use HttpClientBundle\Request\ApiRequest;
use WechatWorkBundle\Request\AgentAware;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;

/**
 * 添加入群欢迎语素材
 *
 * @see https://developer.work.weixin.qq.com/document/path/92366#%E7%BC%96%E8%BE%91%E5%85%A5%E7%BE%A4%E6%AC%A2%E8%BF%8E%E8%AF%AD%E7%B4%A0%E6%9D%90
 */
class EditGroupWelcomeTemplateRequest extends ApiRequest
{
    use AgentAware;
    use FieldTrait;

    /**
     * @var string 欢迎语素材id
     */
    private string $templateId;

    public static function createFromEntity(GroupWelcomeTemplate $template): self
    {
        $request = new self();
        $request->populateFromEntity($template);

        $templateId = $template->getTemplateId();
        if (null !== $templateId) {
            $request->setTemplateId($templateId);
        }

        return $request;
    }

    public function getRequestPath(): string
    {
        return '/cgi-bin/externalcontact/group_welcome_template/edit';
    }

    /**
     * @return array<string, mixed>
     */
    public function getRequestOptions(): array
    {
        $json = $this->getFieldJson();
        $json['template_id'] = $this->getTemplateId();

        return [
            'json' => $json,
        ];
    }

    public function getTemplateId(): string
    {
        return $this->templateId;
    }

    public function setTemplateId(string $templateId): void
    {
        $this->templateId = $templateId;
    }
}
