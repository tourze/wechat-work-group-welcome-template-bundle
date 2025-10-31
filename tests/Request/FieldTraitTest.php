<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Request;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;
use WechatWorkGroupWelcomeTemplateBundle\Request\FieldTrait;

/**
 * @internal
 */
#[CoversClass(FieldTrait::class)]
final class FieldTraitTest extends TestCase
{
    private TestFieldTraitUser $traitUser;

    protected function setUp(): void
    {
        parent::setUp();
        $this->traitUser = new TestFieldTraitUser();
    }

    public function testTraitMethodsExist(): void
    {
        // 测试核心方法可调用性，而不是检查方法存在性
        $this->assertIsBool($this->traitUser->isNotify());
        $this->traitUser->setNotify(true);  // setter now returns void
        $this->assertIsArray($this->traitUser->getFieldJson());
        $this->assertNull($this->traitUser->getTextContent());
    }

    public function testDefaultValues(): void
    {
        $this->assertTrue($this->traitUser->isNotify());
        $this->assertNull($this->traitUser->getTextContent());
        $this->assertNull($this->traitUser->getImageMediaId());
        $this->assertNull($this->traitUser->getImagePicUrl());
        $this->assertNull($this->traitUser->getLinkTitle());
        $this->assertNull($this->traitUser->getLinkPicUrl());
        $this->assertNull($this->traitUser->getLinkDesc());
        $this->assertNull($this->traitUser->getLinkUrl());
        $this->assertNull($this->traitUser->getMiniprogramTitle());
        $this->assertNull($this->traitUser->getMiniprogramPicMediaId());
        $this->assertNull($this->traitUser->getMiniprogramAppId());
        $this->assertNull($this->traitUser->getMiniprogramPage());
        $this->assertNull($this->traitUser->getFileMediaId());
        $this->assertNull($this->traitUser->getVideoMediaId());
    }

    public function testNotifyGetterAndSetter(): void
    {
        $this->traitUser->setNotify(true);
        $this->assertTrue($this->traitUser->isNotify());

        $this->traitUser->setNotify(false);
        $this->assertFalse($this->traitUser->isNotify());

        $this->traitUser->setNotify(null);
        $this->assertFalse($this->traitUser->isNotify()); // Defaults to false
    }

    public function testTextContentGetterAndSetter(): void
    {
        $textContent = 'Test message content';

        $this->traitUser->setTextContent($textContent);
        $this->assertSame($textContent, $this->traitUser->getTextContent());

        $this->traitUser->setTextContent(null);
        $this->assertNull($this->traitUser->getTextContent());
    }

    public function testImageMediaIdGetterAndSetter(): void
    {
        $imageMediaId = 'test_image_media_id';

        $this->traitUser->setImageMediaId($imageMediaId);
        $this->assertSame($imageMediaId, $this->traitUser->getImageMediaId());

        $this->traitUser->setImageMediaId(null);
        $this->assertNull($this->traitUser->getImageMediaId());
    }

    public function testImagePicUrlGetterAndSetter(): void
    {
        $imagePicUrl = 'https://example.com/test-image.jpg';

        $this->traitUser->setImagePicUrl($imagePicUrl);
        $this->assertSame($imagePicUrl, $this->traitUser->getImagePicUrl());

        $this->traitUser->setImagePicUrl(null);
        $this->assertNull($this->traitUser->getImagePicUrl());
    }

    public function testLinkTitleGetterAndSetter(): void
    {
        $linkTitle = 'Test Link Title';

        $this->traitUser->setLinkTitle($linkTitle);
        $this->assertSame($linkTitle, $this->traitUser->getLinkTitle());

        $this->traitUser->setLinkTitle(null);
        $this->assertNull($this->traitUser->getLinkTitle());
    }

    public function testLinkPicUrlGetterAndSetter(): void
    {
        $linkPicUrl = 'https://example.com/test-link-image.jpg';

        $this->traitUser->setLinkPicUrl($linkPicUrl);
        $this->assertSame($linkPicUrl, $this->traitUser->getLinkPicUrl());

        $this->traitUser->setLinkPicUrl(null);
        $this->assertNull($this->traitUser->getLinkPicUrl());
    }

    public function testLinkDescGetterAndSetter(): void
    {
        $linkDesc = 'Test link description';

        $this->traitUser->setLinkDesc($linkDesc);
        $this->assertSame($linkDesc, $this->traitUser->getLinkDesc());

        $this->traitUser->setLinkDesc(null);
        $this->assertNull($this->traitUser->getLinkDesc());
    }

    public function testLinkUrlGetterAndSetter(): void
    {
        $linkUrl = 'https://example.com/test-link';

        $this->traitUser->setLinkUrl($linkUrl);
        $this->assertSame($linkUrl, $this->traitUser->getLinkUrl());

        $this->traitUser->setLinkUrl(null);
        $this->assertNull($this->traitUser->getLinkUrl());
    }

    public function testMiniprogramTitleGetterAndSetter(): void
    {
        $miniprogramTitle = 'Test Mini Program';

        $this->traitUser->setMiniprogramTitle($miniprogramTitle);
        $this->assertSame($miniprogramTitle, $this->traitUser->getMiniprogramTitle());

        $this->traitUser->setMiniprogramTitle(null);
        $this->assertNull($this->traitUser->getMiniprogramTitle());
    }

    public function testMiniprogramPicMediaIdGetterAndSetter(): void
    {
        $miniprogramPicMediaId = 'test_miniprogram_media_id';

        $this->traitUser->setMiniprogramPicMediaId($miniprogramPicMediaId);
        $this->assertSame($miniprogramPicMediaId, $this->traitUser->getMiniprogramPicMediaId());

        $this->traitUser->setMiniprogramPicMediaId(null);
        $this->assertNull($this->traitUser->getMiniprogramPicMediaId());
    }

    public function testMiniprogramAppIdGetterAndSetter(): void
    {
        $miniprogramAppId = 'wx1234567890abcdef';

        $this->traitUser->setMiniprogramAppId($miniprogramAppId);
        $this->assertSame($miniprogramAppId, $this->traitUser->getMiniprogramAppId());

        $this->traitUser->setMiniprogramAppId(null);
        $this->assertNull($this->traitUser->getMiniprogramAppId());
    }

    public function testMiniprogramPageGetterAndSetter(): void
    {
        $miniprogramPage = '/pages/test/index';

        $this->traitUser->setMiniprogramPage($miniprogramPage);
        $this->assertSame($miniprogramPage, $this->traitUser->getMiniprogramPage());

        $this->traitUser->setMiniprogramPage(null);
        $this->assertNull($this->traitUser->getMiniprogramPage());
    }

    public function testFileMediaIdGetterAndSetter(): void
    {
        $fileMediaId = 'test_file_media_id';

        $this->traitUser->setFileMediaId($fileMediaId);
        $this->assertSame($fileMediaId, $this->traitUser->getFileMediaId());

        $this->traitUser->setFileMediaId(null);
        $this->assertNull($this->traitUser->getFileMediaId());
    }

    public function testVideoMediaIdGetterAndSetter(): void
    {
        $videoMediaId = 'test_video_media_id';

        $this->traitUser->setVideoMediaId($videoMediaId);
        $this->assertSame($videoMediaId, $this->traitUser->getVideoMediaId());

        $this->traitUser->setVideoMediaId(null);
        $this->assertNull($this->traitUser->getVideoMediaId());
    }

    public function testGetFieldJsonWithBasicData(): void
    {
        $this->traitUser->setNotify(true);
        $this->traitUser->setTextContent('Test message');

        $json = $this->traitUser->getFieldJson();

        $this->assertIsArray($json);
        $this->assertArrayHasKey('notify', $json);
        $this->assertSame(1, $json['notify']);
        $this->assertArrayHasKey('text', $json);
        $text = $json['text'];
        $this->assertIsArray($text);
        $this->assertArrayHasKey('content', $text);
        $this->assertSame('Test message', $text['content']);
    }

    public function testGetFieldJsonWithNotifyFalse(): void
    {
        $this->traitUser->setNotify(false);

        $json = $this->traitUser->getFieldJson();

        $this->assertIsArray($json);
        $this->assertArrayHasKey('notify', $json);
        $this->assertSame(0, $json['notify']);
    }

    public function testGetFieldJsonWithImageMediaId(): void
    {
        $this->traitUser->setImageMediaId('test_media_id');

        $json = $this->traitUser->getFieldJson();

        $this->assertIsArray($json);
        $this->assertArrayHasKey('image', $json);
        $image = $json['image'];
        $this->assertIsArray($image);
        $this->assertArrayHasKey('media_id', $image);
        $this->assertSame('test_media_id', $image['media_id']);
    }

    public function testGetFieldJsonWithImagePicUrl(): void
    {
        $this->traitUser->setImagePicUrl('https://example.com/test-image.jpg');

        $json = $this->traitUser->getFieldJson();

        $this->assertIsArray($json);
        $this->assertArrayHasKey('image', $json);
        $image = $json['image'];
        $this->assertIsArray($image);
        $this->assertArrayHasKey('pic_url', $image);
        $this->assertSame('https://example.com/test-image.jpg', $image['pic_url']);
    }

    public function testGetFieldJsonWithLink(): void
    {
        $this->traitUser->setLinkTitle('Test Link');
        $this->traitUser->setLinkPicUrl('https://example.com/test-link-image.jpg');
        $this->traitUser->setLinkDesc('Test Link Description');
        $this->traitUser->setLinkUrl('https://example.com/test-link');

        $json = $this->traitUser->getFieldJson();

        $this->assertIsArray($json);
        $this->assertArrayHasKey('link', $json);
        $link = $json['link'];
        $this->assertIsArray($link);
        $this->assertSame('Test Link', $link['title']);
        $this->assertSame('https://example.com/test-link-image.jpg', $link['picurl']);
        $this->assertSame('Test Link Description', $link['desc']);
        $this->assertSame('https://example.com/test-link', $link['url']);
    }

    public function testGetFieldJsonWithMiniprogram(): void
    {
        $this->traitUser->setMiniprogramTitle('Test Mini Program');
        $this->traitUser->setMiniprogramPicMediaId('test_miniprogram_media_id');
        $this->traitUser->setMiniprogramAppId('wx1234567890');
        $this->traitUser->setMiniprogramPage('/pages/test');

        $json = $this->traitUser->getFieldJson();

        $this->assertIsArray($json);
        $this->assertArrayHasKey('miniprogram', $json);
        $miniprogram = $json['miniprogram'];
        $this->assertIsArray($miniprogram);
        $this->assertSame('Test Mini Program', $miniprogram['title']);
        $this->assertSame('test_miniprogram_media_id', $miniprogram['pic_media_id']);
        $this->assertSame('wx1234567890', $miniprogram['appid']);
        $this->assertSame('/pages/test', $miniprogram['page']);
    }

    public function testGetFieldJsonWithFile(): void
    {
        $this->traitUser->setFileMediaId('test_file_media_id');

        $json = $this->traitUser->getFieldJson();

        $this->assertIsArray($json);
        $this->assertArrayHasKey('file', $json);
        $file = $json['file'];
        $this->assertIsArray($file);
        $this->assertArrayHasKey('media_id', $file);
        $this->assertSame('test_file_media_id', $file['media_id']);
    }

    public function testGetFieldJsonWithVideo(): void
    {
        $this->traitUser->setVideoMediaId('test_video_media_id');

        $json = $this->traitUser->getFieldJson();

        $this->assertIsArray($json);
        $this->assertArrayHasKey('video', $json);
        $video = $json['video'];
        $this->assertIsArray($video);
        $this->assertArrayHasKey('media_id', $video);
        $this->assertSame('test_video_media_id', $video['media_id']);
    }

    public function testGetFieldJsonWithEmptyData(): void
    {
        $json = $this->traitUser->getFieldJson();

        $this->assertIsArray($json);
        $this->assertArrayHasKey('notify', $json);
        $this->assertSame(1, $json['notify']); // Default notify is true
        $this->assertCount(1, $json); // Only notify should be present
    }

    public function testPopulateFromEntity(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setNotify(false);
        $template->setTextContent('Populated from entity');

        $this->traitUser->publicPopulateFromEntity($template);

        $this->assertFalse($this->traitUser->isNotify());
        $this->assertSame('Populated from entity', $this->traitUser->getTextContent());
    }

    public function testPopulateFromEntityWithNullValues(): void
    {
        $template = new GroupWelcomeTemplate();
        $template->setNotify(null);
        $template->setTextContent(null);

        $this->traitUser->publicPopulateFromEntity($template);

        $this->assertFalse($this->traitUser->isNotify()); // Default to false when null
        $this->assertNull($this->traitUser->getTextContent());
    }

    public function testSetterMethods(): void
    {
        // Test all setter methods individually since they now return void
        $this->traitUser->setNotify(false);
        $this->traitUser->setTextContent('Fluent test');
        $this->traitUser->setImageMediaId('fluent_image_media');
        $this->traitUser->setImagePicUrl('https://example.com/fluent-image.jpg');
        $this->traitUser->setLinkTitle('Fluent Link');
        $this->traitUser->setLinkPicUrl('https://example.com/fluent-link.jpg');
        $this->traitUser->setLinkDesc('Fluent Link Description');
        $this->traitUser->setLinkUrl('https://fluent-example.com');
        $this->traitUser->setMiniprogramTitle('Fluent Mini Program');
        $this->traitUser->setMiniprogramPicMediaId('fluent_miniprogram_media');
        $this->traitUser->setMiniprogramAppId('wxfluent123456');
        $this->traitUser->setMiniprogramPage('/pages/fluent');
        $this->traitUser->setFileMediaId('fluent_file_media');
        $this->traitUser->setVideoMediaId('fluent_video_media');

        // Verify all values were set correctly
        $this->assertFalse($this->traitUser->isNotify());
        $this->assertSame('Fluent test', $this->traitUser->getTextContent());
        $this->assertSame('fluent_image_media', $this->traitUser->getImageMediaId());
        $this->assertSame('https://example.com/fluent-image.jpg', $this->traitUser->getImagePicUrl());
        $this->assertSame('Fluent Link', $this->traitUser->getLinkTitle());
        $this->assertSame('https://example.com/fluent-link.jpg', $this->traitUser->getLinkPicUrl());
        $this->assertSame('Fluent Link Description', $this->traitUser->getLinkDesc());
        $this->assertSame('https://fluent-example.com', $this->traitUser->getLinkUrl());
        $this->assertSame('Fluent Mini Program', $this->traitUser->getMiniprogramTitle());
        $this->assertSame('fluent_miniprogram_media', $this->traitUser->getMiniprogramPicMediaId());
        $this->assertSame('wxfluent123456', $this->traitUser->getMiniprogramAppId());
        $this->assertSame('/pages/fluent', $this->traitUser->getMiniprogramPage());
        $this->assertSame('fluent_file_media', $this->traitUser->getFileMediaId());
        $this->assertSame('fluent_video_media', $this->traitUser->getVideoMediaId());
    }
}
