<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Request;

use HttpClientBundle\Tests\Request\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\WechatWorkContracts\AgentInterface;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;
use WechatWorkGroupWelcomeTemplateBundle\Request\AddGroupWelcomeTemplateRequest;

/**
 * @internal
 */
#[CoversClass(AddGroupWelcomeTemplateRequest::class)]
final class AddGroupWelcomeTemplateRequestTest extends RequestTestCase
{
    private AddGroupWelcomeTemplateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new AddGroupWelcomeTemplateRequest();
    }

    public function testRequestCreation(): void
    {
        $this->assertInstanceOf(AddGroupWelcomeTemplateRequest::class, $this->request);
    }

    public function testGetRequestPath(): void
    {
        $this->assertSame('/cgi-bin/externalcontact/group_welcome_template/add', $this->request->getRequestPath());
    }

    public function testGetRequestOptionsReturnsJson(): void
    {
        $options = $this->request->getRequestOptions();

        $this->assertArrayHasKey('json', $options);
    }

    public function testGetRequestOptionsWithBasicData(): void
    {
        $this->request->setNotify(true);
        $this->request->setTextContent('Welcome message');

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
        $this->assertSame('Welcome message', $text['content']);
    }

    public function testGetRequestOptionsWithNotifyFalse(): void
    {
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
        $this->request->setImageMediaId('media_id_123');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('image', $json);
        $image = $json['image'];
        $this->assertIsArray($image);
        $this->assertArrayHasKey('media_id', $image);
        $this->assertSame('media_id_123', $image['media_id']);
    }

    public function testGetRequestOptionsWithImagePicUrl(): void
    {
        $this->request->setImagePicUrl('https://example.com/image.jpg');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('image', $json);
        $image = $json['image'];
        $this->assertIsArray($image);
        $this->assertArrayHasKey('pic_url', $image);
        $this->assertSame('https://example.com/image.jpg', $image['pic_url']);
    }

    public function testGetRequestOptionsWithLink(): void
    {
        $this->request->setLinkTitle('Link Title');
        $this->request->setLinkPicUrl('https://example.com/link.jpg');
        $this->request->setLinkDesc('Link Description');
        $this->request->setLinkUrl('https://example.com');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('link', $json);
        $link = $json['link'];
        $this->assertIsArray($link);
        $this->assertSame('Link Title', $link['title']);
        $this->assertSame('https://example.com/link.jpg', $link['picurl']);
        $this->assertSame('Link Description', $link['desc']);
        $this->assertSame('https://example.com', $link['url']);
    }

    public function testGetRequestOptionsWithMiniprogram(): void
    {
        $this->request->setMiniprogramTitle('Mini Program');
        $this->request->setMiniprogramPicMediaId('miniprogram_media_id');
        $this->request->setMiniprogramAppId('wx1234567890');
        $this->request->setMiniprogramPage('/pages/index');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('miniprogram', $json);
        $miniprogram = $json['miniprogram'];
        $this->assertIsArray($miniprogram);
        $this->assertSame('Mini Program', $miniprogram['title']);
        $this->assertSame('miniprogram_media_id', $miniprogram['pic_media_id']);
        $this->assertSame('wx1234567890', $miniprogram['appid']);
        $this->assertSame('/pages/index', $miniprogram['page']);
    }

    public function testGetRequestOptionsWithFile(): void
    {
        $this->request->setFileMediaId('file_media_id');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('file', $json);
        $file = $json['file'];
        $this->assertIsArray($file);
        $this->assertArrayHasKey('media_id', $file);
        $this->assertSame('file_media_id', $file['media_id']);
    }

    public function testGetRequestOptionsWithVideo(): void
    {
        $this->request->setVideoMediaId('video_media_id');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('video', $json);
        $video = $json['video'];
        $this->assertIsArray($video);
        $this->assertArrayHasKey('media_id', $video);
        $this->assertSame('video_media_id', $video['media_id']);
    }

    public function testCreateFromEntity(): void
    {
        $template = new GroupWelcomeTemplate();
        $agent = $this->createMock(AgentInterface::class);
        $agent->method('getAgentId')->willReturn('agent_123');

        $template->setAgent($agent);
        $template->setNotify(true);
        $template->setTextContent('Welcome from entity');

        $request = AddGroupWelcomeTemplateRequest::createFromEntity($template);

        $this->assertInstanceOf(AddGroupWelcomeTemplateRequest::class, $request);
        $this->assertSame($agent, $request->getAgent());
        $this->assertTrue($request->isNotify());
        $this->assertSame('Welcome from entity', $request->getTextContent());
    }

    public function testCreateFromEntityWithNullValues(): void
    {
        $template = new GroupWelcomeTemplate();
        $agent = $this->createMock(AgentInterface::class);
        $agent->method('getAgentId')->willReturn('agent_123');

        $template->setAgent($agent);
        $template->setNotify(null);
        $template->setTextContent(null);

        $request = AddGroupWelcomeTemplateRequest::createFromEntity($template);

        $this->assertInstanceOf(AddGroupWelcomeTemplateRequest::class, $request);
        $this->assertSame($agent, $request->getAgent());
        $this->assertFalse($request->isNotify()); // Default to false when null
        $this->assertNull($request->getTextContent());
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

    public function testSetterMethods(): void
    {
        // Test all setter methods individually since they now return void
        $this->request->setNotify(false);
        $this->request->setTextContent('Test message');
        $this->request->setImageMediaId('image_media');
        $this->request->setImagePicUrl('https://example.com/image.jpg');
        $this->request->setLinkTitle('Link Title');
        $this->request->setLinkPicUrl('https://example.com/link.jpg');
        $this->request->setLinkDesc('Link Description');
        $this->request->setLinkUrl('https://example.com');
        $this->request->setMiniprogramTitle('Mini Program');
        $this->request->setMiniprogramPicMediaId('miniprogram_media');
        $this->request->setMiniprogramAppId('wx1234567890');
        $this->request->setMiniprogramPage('/pages/index');
        $this->request->setFileMediaId('file_media');
        $this->request->setVideoMediaId('video_media');

        // Verify all values were set correctly
        $this->assertFalse($this->request->isNotify());
        $this->assertSame('Test message', $this->request->getTextContent());
        $this->assertSame('image_media', $this->request->getImageMediaId());
        $this->assertSame('https://example.com/image.jpg', $this->request->getImagePicUrl());
        $this->assertSame('Link Title', $this->request->getLinkTitle());
        $this->assertSame('https://example.com/link.jpg', $this->request->getLinkPicUrl());
        $this->assertSame('Link Description', $this->request->getLinkDesc());
        $this->assertSame('https://example.com', $this->request->getLinkUrl());
        $this->assertSame('Mini Program', $this->request->getMiniprogramTitle());
        $this->assertSame('miniprogram_media', $this->request->getMiniprogramPicMediaId());
        $this->assertSame('wx1234567890', $this->request->getMiniprogramAppId());
        $this->assertSame('/pages/index', $this->request->getMiniprogramPage());
        $this->assertSame('file_media', $this->request->getFileMediaId());
        $this->assertSame('video_media', $this->request->getVideoMediaId());
    }
}
