<?php

declare(strict_types=1);

namespace WechatWorkGroupWelcomeTemplateBundle\Tests\Request;

use HttpClientBundle\Test\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use WechatWorkGroupWelcomeTemplateBundle\Request\GetGroupWelcomeTemplateRequest;

/**
 * @internal
 */
#[CoversClass(GetGroupWelcomeTemplateRequest::class)]
final class GetGroupWelcomeTemplateRequestTest extends RequestTestCase
{
    private GetGroupWelcomeTemplateRequest $request;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new GetGroupWelcomeTemplateRequest();
    }

    public function testRequestCreation(): void
    {
        $this->assertInstanceOf(GetGroupWelcomeTemplateRequest::class, $this->request);
    }

    public function testGetRequestPath(): void
    {
        $this->assertSame('/cgi-bin/externalcontact/group_welcome_template/get', $this->request->getRequestPath());
    }

    public function testGetRequestOptionsReturnsJson(): void
    {
        $this->request->setTemplateId('test_template_123');

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $this->assertIsArray($options['json']);
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
        $templateId = 'get_template_456';

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
        $templateId = 'get_template_123@#$%';

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

    public function testTemplateIdWithUnicode(): void
    {
        $templateId = '模板_测试_123';

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

    public function testTemplateIdWithNumbersOnly(): void
    {
        $templateId = '1234567890';

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

    public function testMultipleTemplateIdChanges(): void
    {
        $templateId1 = 'first_template';
        $templateId2 = 'second_template';
        $templateId3 = 'third_template';

        $this->request->setTemplateId($templateId1);
        $this->assertSame($templateId1, $this->request->getTemplateId());

        $this->request->setTemplateId($templateId2);
        $this->assertSame($templateId2, $this->request->getTemplateId());

        $this->request->setTemplateId($templateId3);
        $this->assertSame($templateId3, $this->request->getTemplateId());
    }

    public function testTemplateIdSetting(): void
    {
        $this->request->setTemplateId('fluent_template_789');
        $this->assertSame('fluent_template_789', $this->request->getTemplateId());
    }

    public function testJsonStructureConsistency(): void
    {
        $templateId = 'consistency_test';
        $this->request->setTemplateId($templateId);

        $options = $this->request->getRequestOptions();

        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $this->assertIsArray($options['json']);
        $this->assertCount(1, $options['json']); // Only template_id should be present
        $this->assertArrayHasKey('template_id', $options['json']);
    }

    public function testRequestOptionsAreImmutable(): void
    {
        $templateId = 'immutable_test';
        $this->request->setTemplateId($templateId);

        $options1 = $this->request->getRequestOptions();
        $options2 = $this->request->getRequestOptions();

        $this->assertSame($options1, $options2);
        $this->assertIsArray($options1);
        $this->assertArrayHasKey('json', $options1);
        $json1 = $options1['json'];
        $this->assertIsArray($json1);
        $this->assertSame($templateId, $json1['template_id']);

        $this->assertIsArray($options2);
        $this->assertArrayHasKey('json', $options2);
        $json2 = $options2['json'];
        $this->assertIsArray($json2);
        $this->assertSame($templateId, $json2['template_id']);
    }
}
