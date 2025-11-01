<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Request;

use HttpClientBundle\Test\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use WechatWorkGroupWelcomeTemplateBundle\Request\DeleteGroupWelcomeTemplateRequest;

/**
 * @internal
 */
#[CoversClass(DeleteGroupWelcomeTemplateRequest::class)]
final class DeleteGroupWelcomeTemplateRequestTest extends RequestTestCase
{
    private DeleteGroupWelcomeTemplateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new DeleteGroupWelcomeTemplateRequest();
    }

    public function testRequestCreation(): void
    {
        $this->assertInstanceOf(DeleteGroupWelcomeTemplateRequest::class, $this->request);
    }

    public function testGetRequestPath(): void
    {
        $this->assertSame('/cgi-bin/externalcontact/group_welcome_template/del', $this->request->getRequestPath());
    }

    public function testGetRequestOptionsReturnsJson(): void
    {
        $this->request->setTemplateId('test_template_123');

        $options = $this->request->getRequestOptions();

        $this->assertArrayHasKey('json', $options);
    }

    public function testGetRequestOptionsWithTemplateId(): void
    {
        $templateId = 'test_template_123';
        $this->request->setTemplateId($templateId);

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('template_id', $json);
        $this->assertSame($templateId, $json['template_id']);
    }

    public function testGetRequestOptionsWithoutTemplateId(): void
    {
        // templateId 是必需的属性，在未设置的情况下访问会抛出 Error
        // 这个测试验证这种行为符合预期
        $this->expectException(\Error::class);
        $this->expectExceptionMessage('must not be accessed before initialization');

        $this->request->getRequestOptions();
    }

    public function testTemplateIdGetterAndSetter(): void
    {
        $templateId = 'test_template_456';

        $this->request->setTemplateId($templateId);
        $this->assertSame($templateId, $this->request->getTemplateId());
    }

    public function testTemplateIdWithEmptyString(): void
    {
        $this->request->setTemplateId('');
        $this->assertSame('', $this->request->getTemplateId());

        $options = $this->request->getRequestOptions();
        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('template_id', $json);
        $this->assertSame('', $json['template_id']);
    }

    public function testTemplateIdWithSpecialCharacters(): void
    {
        $templateId = 'template_123@#$%';

        $this->request->setTemplateId($templateId);
        $this->assertSame($templateId, $this->request->getTemplateId());

        $options = $this->request->getRequestOptions();
        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('template_id', $json);
        $this->assertSame($templateId, $json['template_id']);
    }

    public function testTemplateIdWithLongString(): void
    {
        $templateId = str_repeat('a', 1000);

        $this->request->setTemplateId($templateId);
        $this->assertSame($templateId, $this->request->getTemplateId());

        $options = $this->request->getRequestOptions();
        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $json = $options['json'];
        $this->assertIsArray($json);
        $this->assertArrayHasKey('template_id', $json);
        $this->assertSame($templateId, $json['template_id']);
    }

    public function testSetterMethod(): void
    {
        // Test setter method since it now returns void
        $this->request->setTemplateId('test_template_789');

        // Verify the value was set correctly
        $this->assertSame('test_template_789', $this->request->getTemplateId());
    }
}
