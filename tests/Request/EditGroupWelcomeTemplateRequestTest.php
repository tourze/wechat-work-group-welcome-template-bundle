<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Request;

use HttpClientBundle\Tests\Request\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\WechatWorkContracts\AgentInterface;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;
use WechatWorkGroupWelcomeTemplateBundle\Request\EditGroupWelcomeTemplateRequest;

/**
 * @internal
 */
#[CoversClass(EditGroupWelcomeTemplateRequest::class)]
final class EditGroupWelcomeTemplateRequestTest extends RequestTestCase
{
    private EditGroupWelcomeTemplateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new EditGroupWelcomeTemplateRequest();
    }

    public function testRequestCreation(): void
    {
        $this->assertInstanceOf(EditGroupWelcomeTemplateRequest::class, $this->request);
    }

    public function testGetRequestPath(): void
    {
        $this->assertSame('/cgi-bin/externalcontact/group_welcome_template/edit', $this->request->getRequestPath());
    }

    public function testGetRequestOptionsReturnsJson(): void
    {
        // 设置必需的 templateId
        $this->request->setTemplateId('test_template_id');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $this->assertIsArray($options['json']);
    }

    public function testGetRequestOptionsWithBasicData(): void
    {
        $this->request->setTemplateId('test_template_123');
        $this->request->setNotify(true);
        $this->request->setTextContent('Updated welcome message');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('notify', $json);
        $this->assertSame(1, $json['notify']);
        $this->assertArrayHasKey('text', $json);
        $text = $json['text'];
        $this->assertIsArray($text);
        $this->assertArrayHasKey('content', $text);
        $this->assertSame('Updated welcome message', $text['content']);
    }

    public function testGetRequestOptionsWithNotifyFalse(): void
    {
        // 设置必需的 templateId
        $this->request->setTemplateId('test_template_id');
        $this->request->setNotify(false);

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('notify', $json);
        $this->assertSame(0, $json['notify']);
    }

    public function testGetRequestOptionsWithImageMediaId(): void
    {
        // 设置必需的 templateId
        $this->request->setTemplateId('test_template_id');
        $this->request->setImageMediaId('updated_media_id');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('image', $json);
        $image = $json['image'];
        $this->assertIsArray($image);
        $this->assertArrayHasKey('media_id', $image);
        $this->assertSame('updated_media_id', $image['media_id']);
    }

    public function testGetRequestOptionsWithImagePicUrl(): void
    {
        // 设置必需的 templateId
        $this->request->setTemplateId('test_template_id');
        $this->request->setImagePicUrl('https://example.com/updated-image.jpg');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('image', $json);
        $image = $json['image'];
        $this->assertIsArray($image);
        $this->assertArrayHasKey('pic_url', $image);
        $this->assertSame('https://example.com/updated-image.jpg', $image['pic_url']);
    }

    public function testGetRequestOptionsWithLink(): void
    {
        // 设置必需的 templateId
        $this->request->setTemplateId('test_template_id');
        $this->request->setLinkTitle('Updated Link Title');
        $this->request->setLinkPicUrl('https://example.com/updated-link.jpg');
        $this->request->setLinkDesc('Updated Link Description');
        $this->request->setLinkUrl('https://updated-example.com');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('link', $json);
        $link = $json['link'];
        $this->assertIsArray($link);
        $this->assertSame('Updated Link Title', $link['title']);
        $this->assertSame('https://example.com/updated-link.jpg', $link['picurl']);
        $this->assertSame('Updated Link Description', $link['desc']);
        $this->assertSame('https://updated-example.com', $link['url']);
    }

    public function testGetRequestOptionsWithMiniprogram(): void
    {
        // 设置必需的 templateId
        $this->request->setTemplateId('test_template_id');
        $this->request->setMiniprogramTitle('Updated Mini Program');
        $this->request->setMiniprogramPicMediaId('updated_miniprogram_media_id');
        $this->request->setMiniprogramAppId('wx9876543210');
        $this->request->setMiniprogramPage('/pages/updated');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('miniprogram', $json);
        $miniprogram = $json['miniprogram'];
        $this->assertIsArray($miniprogram);
        $this->assertSame('Updated Mini Program', $miniprogram['title']);
        $this->assertSame('updated_miniprogram_media_id', $miniprogram['pic_media_id']);
        $this->assertSame('wx9876543210', $miniprogram['appid']);
        $this->assertSame('/pages/updated', $miniprogram['page']);
    }

    public function testGetRequestOptionsWithFile(): void
    {
        // 设置必需的 templateId
        $this->request->setTemplateId('test_template_id');
        $this->request->setFileMediaId('updated_file_media_id');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('file', $json);
        $file = $json['file'];
        $this->assertIsArray($file);
        $this->assertArrayHasKey('media_id', $file);
        $this->assertSame('updated_file_media_id', $file['media_id']);
    }

    public function testGetRequestOptionsWithVideo(): void
    {
        // 设置必需的 templateId
        $this->request->setTemplateId('test_template_id');
        $this->request->setVideoMediaId('updated_video_media_id');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('video', $json);
        $video = $json['video'];
        $this->assertIsArray($video);
        $this->assertArrayHasKey('media_id', $video);
        $this->assertSame('updated_video_media_id', $video['media_id']);
    }

    public function testCreateFromEntity(): void
    {
        $template = new GroupWelcomeTemplate();
        $agent = $this->createMock(AgentInterface::class);
        $agent->method('getAgentId')->willReturn('agent_123');

        $template->setAgent($agent);
        $template->setNotify(false);
        $template->setTextContent('Updated from entity');

        $request = EditGroupWelcomeTemplateRequest::createFromEntity($template);

        $this->assertInstanceOf(EditGroupWelcomeTemplateRequest::class, $request);
        $this->assertSame($agent, $request->getAgent());
        $this->assertFalse($request->isNotify());
        $this->assertSame('Updated from entity', $request->getTextContent());
    }

    public function testCreateFromEntityWithNullValues(): void
    {
        $template = new GroupWelcomeTemplate();
        $agent = $this->createMock(AgentInterface::class);
        $agent->method('getAgentId')->willReturn('agent_123');

        $template->setAgent($agent);
        $template->setNotify(null);
        $template->setTextContent(null);

        $request = EditGroupWelcomeTemplateRequest::createFromEntity($template);

        $this->assertInstanceOf(EditGroupWelcomeTemplateRequest::class, $request);
        $this->assertSame($agent, $request->getAgent());
        $this->assertFalse($request->isNotify()); // Default to false when null
        $this->assertNull($request->getTextContent());
    }

    public function testTemplateIdGetterAndSetter(): void
    {
        $templateId = 'edit_template_123';

        $this->request->setTemplateId($templateId);
        $this->assertSame($templateId, $this->request->getTemplateId());
    }

    public function testDefaultValues(): void
    {
        $this->assertTrue($this->request->isNotify());
        $this->assertNull($this->request->getTextContent());
        $this->assertNull($this->request->getImageMediaId());
        $this->assertNull($this->request->getImagePicUrl());
        $this->assertNull($this->request->getLinkTitle());
        $this->assertNull($this->request->getLinkPicUrl());
        $this->assertNull($this->request->getLinkDesc());
        $this->assertNull($this->request->getLinkUrl());
        $this->assertNull($this->request->getMiniprogramTitle());
        $this->assertNull($this->request->getMiniprogramPicMediaId());
        $this->assertNull($this->request->getMiniprogramAppId());
        $this->assertNull($this->request->getMiniprogramPage());
        $this->assertNull($this->request->getFileMediaId());
        $this->assertNull($this->request->getVideoMediaId());
    }

    public function testFluentInterface(): void
    {
        $this->request->setTemplateId('edit_template_456');
        $this->request->setNotify(false);
        $this->request->setTextContent('Updated message');
        $this->request->setImageMediaId('updated_image_media');
        $this->request->setImagePicUrl('https://example.com/updated-image.jpg');
        $this->request->setLinkTitle('Updated Link Title');
        $this->request->setLinkPicUrl('https://example.com/updated-link.jpg');
        $this->request->setLinkDesc('Updated Link Description');
        $this->request->setLinkUrl('https://updated-example.com');
        $this->request->setMiniprogramTitle('Updated Mini Program');
        $this->request->setMiniprogramPicMediaId('updated_miniprogram_media');
        $this->request->setMiniprogramAppId('wx9876543210');
        $this->request->setMiniprogramPage('/pages/updated');
        $this->request->setFileMediaId('updated_file_media');
        $this->request->setVideoMediaId('updated_video_media');

        // 验证所有值都已正确设置
        $this->assertSame('edit_template_456', $this->request->getTemplateId());
        $this->assertFalse($this->request->isNotify());
        $this->assertSame('Updated message', $this->request->getTextContent());
        $this->assertSame('updated_image_media', $this->request->getImageMediaId());
        $this->assertSame('https://example.com/updated-image.jpg', $this->request->getImagePicUrl());
        $this->assertSame('Updated Link Title', $this->request->getLinkTitle());
        $this->assertSame('https://example.com/updated-link.jpg', $this->request->getLinkPicUrl());
        $this->assertSame('Updated Link Description', $this->request->getLinkDesc());
        $this->assertSame('https://updated-example.com', $this->request->getLinkUrl());
        $this->assertSame('Updated Mini Program', $this->request->getMiniprogramTitle());
        $this->assertSame('updated_miniprogram_media', $this->request->getMiniprogramPicMediaId());
        $this->assertSame('wx9876543210', $this->request->getMiniprogramAppId());
        $this->assertSame('/pages/updated', $this->request->getMiniprogramPage());
        $this->assertSame('updated_file_media', $this->request->getFileMediaId());
        $this->assertSame('updated_video_media', $this->request->getVideoMediaId());
    }
}
