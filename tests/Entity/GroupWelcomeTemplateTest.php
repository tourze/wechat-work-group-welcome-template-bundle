<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use Tourze\WechatWorkContracts\AgentInterface;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;
use WechatWorkMediaBundle\Entity\TempMedia;

/**
 * @internal
 */
#[CoversClass(GroupWelcomeTemplate::class)]
final class GroupWelcomeTemplateTest extends AbstractEntityTestCase
{
    private GroupWelcomeTemplate $template;

    protected function createEntity(): object
    {
        return new GroupWelcomeTemplate();
    }

    /**
     * @return iterable<array{string, mixed}>
     */
    public static function propertiesProvider(): iterable
    {
        return [
            'templateId' => ['templateId', 'test_template_123'],
            'textContent' => ['textContent', 'Welcome message'],
            'imagePicUrl' => ['imagePicUrl', 'https://example.com/image.jpg'],
            'linkTitle' => ['linkTitle', 'Link Title'],
            'linkPicUrl' => ['linkPicUrl', 'https://example.com/link.jpg'],
            'linkDesc' => ['linkDesc', 'Link Description'],
            'linkUrl' => ['linkUrl', 'https://example.com'],
            'miniprogramTitle' => ['miniprogramTitle', 'Mini Program Title'],
            'miniprogramAppId' => ['miniprogramAppId', 'wx1234567890'],
            'miniprogramPage' => ['miniprogramPage', '/pages/index/index'],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->template = new GroupWelcomeTemplate();
    }

    public function testAgentGetterAndSetter(): void
    {
        $agent = $this->createMock(AgentInterface::class);

        $this->template->setAgent($agent);
        $this->assertSame($agent, $this->template->getAgent());
    }

    public function testTemplateIdGetterAndSetter(): void
    {
        $templateId = 'test_template_123';

        $this->template->setTemplateId($templateId);
        $this->assertSame($templateId, $this->template->getTemplateId());
    }

    public function testNotifyGetterAndSetter(): void
    {
        $this->template->setNotify(true);
        $this->assertTrue($this->template->isNotify());

        $this->template->setNotify(false);
        $this->assertFalse($this->template->isNotify());

        $this->template->setNotify(null);
        $this->assertNull($this->template->isNotify());
    }

    public function testTextContentGetterAndSetter(): void
    {
        $textContent = 'Welcome to our group!';

        $this->template->setTextContent($textContent);
        $this->assertSame($textContent, $this->template->getTextContent());

        $this->template->setTextContent(null);
        $this->assertNull($this->template->getTextContent());
    }

    public function testImageMediaGetterAndSetter(): void
    {
        $imageMedia = $this->createMock(TempMedia::class);

        $this->template->setImageMedia($imageMedia);
        $this->assertSame($imageMedia, $this->template->getImageMedia());

        $this->template->setImageMedia(null);
        $this->assertNull($this->template->getImageMedia());
    }

    public function testImagePicUrlGetterAndSetter(): void
    {
        $imagePicUrl = 'https://example.com/image.jpg';

        $this->template->setImagePicUrl($imagePicUrl);
        $this->assertSame($imagePicUrl, $this->template->getImagePicUrl());

        $this->template->setImagePicUrl(null);
        $this->assertNull($this->template->getImagePicUrl());
    }

    public function testLinkTitleGetterAndSetter(): void
    {
        $linkTitle = 'Check out our website';

        $this->template->setLinkTitle($linkTitle);
        $this->assertSame($linkTitle, $this->template->getLinkTitle());

        $this->template->setLinkTitle(null);
        $this->assertNull($this->template->getLinkTitle());
    }

    public function testLinkPicUrlGetterAndSetter(): void
    {
        $linkPicUrl = 'https://example.com/link-image.jpg';

        $this->template->setLinkPicUrl($linkPicUrl);
        $this->assertSame($linkPicUrl, $this->template->getLinkPicUrl());

        $this->template->setLinkPicUrl(null);
        $this->assertNull($this->template->getLinkPicUrl());
    }

    public function testLinkDescGetterAndSetter(): void
    {
        $linkDesc = 'This is a link description';

        $this->template->setLinkDesc($linkDesc);
        $this->assertSame($linkDesc, $this->template->getLinkDesc());

        $this->template->setLinkDesc(null);
        $this->assertNull($this->template->getLinkDesc());
    }

    public function testLinkUrlGetterAndSetter(): void
    {
        $linkUrl = 'https://example.com';

        $this->template->setLinkUrl($linkUrl);
        $this->assertSame($linkUrl, $this->template->getLinkUrl());

        $this->template->setLinkUrl(null);
        $this->assertNull($this->template->getLinkUrl());
    }

    public function testMiniprogramTitleGetterAndSetter(): void
    {
        $miniprogramTitle = 'Mini Program Title';

        $this->template->setMiniprogramTitle($miniprogramTitle);
        $this->assertSame($miniprogramTitle, $this->template->getMiniprogramTitle());

        $this->template->setMiniprogramTitle(null);
        $this->assertNull($this->template->getMiniprogramTitle());
    }

    public function testMiniprogramMediaGetterAndSetter(): void
    {
        $miniprogramMedia = $this->createMock(TempMedia::class);

        $this->template->setMiniprogramMedia($miniprogramMedia);
        $this->assertSame($miniprogramMedia, $this->template->getMiniprogramMedia());

        $this->template->setMiniprogramMedia(null);
        $this->assertNull($this->template->getMiniprogramMedia());
    }

    public function testMiniprogramAppIdGetterAndSetter(): void
    {
        $miniprogramAppId = 'wx1234567890abcdef';

        $this->template->setMiniprogramAppId($miniprogramAppId);
        $this->assertSame($miniprogramAppId, $this->template->getMiniprogramAppId());

        $this->template->setMiniprogramAppId(null);
        $this->assertNull($this->template->getMiniprogramAppId());
    }

    public function testMiniprogramPageGetterAndSetter(): void
    {
        $miniprogramPage = '/pages/index/index';

        $this->template->setMiniprogramPage($miniprogramPage);
        $this->assertSame($miniprogramPage, $this->template->getMiniprogramPage());

        $this->template->setMiniprogramPage(null);
        $this->assertNull($this->template->getMiniprogramPage());
    }

    public function testFileMediaGetterAndSetter(): void
    {
        $fileMedia = $this->createMock(TempMedia::class);

        $this->template->setFileMedia($fileMedia);
        $this->assertSame($fileMedia, $this->template->getFileMedia());

        $this->template->setFileMedia(null);
        $this->assertNull($this->template->getFileMedia());
    }

    public function testVideoMediaGetterAndSetter(): void
    {
        $videoMedia = $this->createMock(TempMedia::class);

        $this->template->setVideoMedia($videoMedia);
        $this->assertSame($videoMedia, $this->template->getVideoMedia());

        $this->template->setVideoMedia(null);
        $this->assertNull($this->template->getVideoMedia());
    }

    public function testSyncGetterAndSetter(): void
    {
        $this->template->setSync(true);
        $this->assertTrue($this->template->isSync());

        $this->template->setSync(false);
        $this->assertFalse($this->template->isSync());

        $this->template->setSync(null);
        $this->assertNull($this->template->isSync());
    }

    public function testToString(): void
    {
        $this->template->setId('12345');
        $this->assertSame('12345', (string) $this->template);
    }

    public function testDefaultValues(): void
    {
        $this->assertNull($this->template->getAgent());
        $this->assertNull($this->template->getTemplateId());
        $this->assertNull($this->template->getTextContent());
        $this->assertNull($this->template->getImageMedia());
        $this->assertNull($this->template->getImagePicUrl());
        $this->assertNull($this->template->getLinkTitle());
        $this->assertNull($this->template->getLinkPicUrl());
        $this->assertNull($this->template->getLinkDesc());
        $this->assertNull($this->template->getLinkUrl());
        $this->assertNull($this->template->getMiniprogramTitle());
        $this->assertNull($this->template->getMiniprogramMedia());
        $this->assertNull($this->template->getMiniprogramAppId());
        $this->assertNull($this->template->getMiniprogramPage());
        $this->assertNull($this->template->getFileMedia());
        $this->assertNull($this->template->getVideoMedia());
        $this->assertNull($this->template->isSync());
    }

    public function testSetterMethods(): void
    {
        $agent = $this->createMock(AgentInterface::class);
        $imageMedia = $this->createMock(TempMedia::class);
        $miniprogramMedia = $this->createMock(TempMedia::class);
        $fileMedia = $this->createMock(TempMedia::class);
        $videoMedia = $this->createMock(TempMedia::class);

        // Test all setter methods individually since they now return void
        $this->template->setAgent($agent);
        $this->template->setTemplateId('test_template');
        $this->template->setNotify(true);
        $this->template->setTextContent('Welcome message');
        $this->template->setImageMedia($imageMedia);
        $this->template->setImagePicUrl('https://example.com/image.jpg');
        $this->template->setLinkTitle('Link Title');
        $this->template->setLinkPicUrl('https://example.com/link.jpg');
        $this->template->setLinkDesc('Link Description');
        $this->template->setLinkUrl('https://example.com');
        $this->template->setMiniprogramTitle('Mini Program');
        $this->template->setMiniprogramMedia($miniprogramMedia);
        $this->template->setMiniprogramAppId('wx1234567890');
        $this->template->setMiniprogramPage('/pages/index');
        $this->template->setFileMedia($fileMedia);
        $this->template->setVideoMedia($videoMedia);
        $this->template->setSync(true);

        // Verify all values were set correctly
        $this->assertSame($agent, $this->template->getAgent());
        $this->assertSame('test_template', $this->template->getTemplateId());
        $this->assertTrue($this->template->isNotify());
        $this->assertSame('Welcome message', $this->template->getTextContent());
        $this->assertSame($imageMedia, $this->template->getImageMedia());
        $this->assertSame('https://example.com/image.jpg', $this->template->getImagePicUrl());
        $this->assertSame('Link Title', $this->template->getLinkTitle());
        $this->assertSame('https://example.com/link.jpg', $this->template->getLinkPicUrl());
        $this->assertSame('Link Description', $this->template->getLinkDesc());
        $this->assertSame('https://example.com', $this->template->getLinkUrl());
        $this->assertSame('Mini Program', $this->template->getMiniprogramTitle());
        $this->assertSame($miniprogramMedia, $this->template->getMiniprogramMedia());
        $this->assertSame('wx1234567890', $this->template->getMiniprogramAppId());
        $this->assertSame('/pages/index', $this->template->getMiniprogramPage());
        $this->assertSame($fileMedia, $this->template->getFileMedia());
        $this->assertSame($videoMedia, $this->template->getVideoMedia());
        $this->assertTrue($this->template->isSync());
    }
}
