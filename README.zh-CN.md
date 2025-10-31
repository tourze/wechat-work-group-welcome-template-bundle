# 企业微信群欢迎语模板包

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.1-blue.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Symfony](https://img.shields.io/badge/symfony-%3E%3D6.4-black.svg)](https://symfony.com/)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](https://github.com/tourze/php-monorepo)
[![Code Coverage](https://img.shields.io/badge/coverage-98%25-brightgreen.svg)](https://github.com/tourze/php-monorepo)

[English](README.md) | [中文](README.zh-CN.md)

用于管理企业微信群欢迎语模板的 Symfony 包。该包提供了实体、存储库和 API 请求类，
用于创建、编辑和管理发送给新群成员的欢迎消息。

## 目录

- [功能特性](#功能特性)
- [安装](#安装)
- [快速开始](#快速开始)
- [配置](#配置)
- [API 请求](#api-请求)
- [实体属性](#实体属性)
- [事件监听器](#事件监听器)
- [高级用法](#高级用法)
- [测试](#测试)
- [系统要求](#系统要求)
- [许可证](#许可证)
- [参考文档](#参考文档)

## 功能特性

- **实体管理**: 群欢迎语模板的 Doctrine ORM 实体
- **API 集成**: 企业微信外部联系人 API 请求类
- **丰富内容支持**: 支持文本、图片、链接、小程序、文件和视频
- **自动同步**: 事件监听器自动与企业微信同步
- **全面测试**: PHPUnit 完整测试覆盖

## 安装

通过 Composer 安装包：

```bash
composer require tourze/wechat-work-group-welcome-template-bundle
```

## 快速开始

### 1. 创建群欢迎语模板

```php
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;
use WechatWorkGroupWelcomeTemplateBundle\Request\AddGroupWelcomeTemplateRequest;

// 创建新的模板实体
$template = new GroupWelcomeTemplate();
$template->setAgent($agent); // 您的企业微信应用
$template->setNotify(true);
$template->setTextContent('欢迎加入我们的群聊！');
$template->setSync(true); // 启用自动同步

// 保存到数据库（将自动同步到企业微信）
$entityManager->persist($template);
$entityManager->flush();
```

### 2. 手动创建 API 请求

```php
use WechatWorkGroupWelcomeTemplateBundle\Request\AddGroupWelcomeTemplateRequest;

$request = new AddGroupWelcomeTemplateRequest();
$request->setAgent($agent);
$request->setNotify(true);
$request->setTextContent('欢迎加入我们的团队！');
$request->setLinkTitle('了解更多');
$request->setLinkUrl('https://example.com');
$request->setLinkDesc('点击了解我们公司更多信息');

// 使用 WorkService
$response = $workService->request($request);
```

### 3. 富媒体模板

```php
$template = new GroupWelcomeTemplate();
$template->setAgent($agent);
$template->setNotify(true);

// 文本内容
$template->setTextContent('欢迎！这里有一些资源：');

// 图片
$template->setImageMedia($imageMedia); // TempMedia 实体
// 或者
$template->setImagePicUrl('https://example.com/welcome.jpg');

// 链接
$template->setLinkTitle('公司网站');
$template->setLinkUrl('https://company.com');
$template->setLinkDesc('访问我们的网站');
$template->setLinkPicUrl('https://company.com/logo.jpg');

// 小程序
$template->setMiniprogramTitle('团队工具');
$template->setMiniprogramAppId('wxabcd1234');
$template->setMiniprogramPage('pages/welcome');
$template->setMiniprogramMedia($miniprogramMedia);

// 文件
$template->setFileMedia($fileMedia);

// 视频
$template->setVideoMedia($videoMedia);
```

## 配置

包会自动配置服务，无需额外配置。

### 服务配置

服务会自动注册：
- `WechatWorkGroupWelcomeTemplateBundle\Repository\GroupWelcomeTemplateRepository`
- `WechatWorkGroupWelcomeTemplateBundle\EventSubscriber\GroupWelcomeTemplateListener`

## API 请求

包提供了几个企业微信 API 请求类：

### AddGroupWelcomeTemplateRequest

```php
$request = AddGroupWelcomeTemplateRequest::createFromEntity($template);
$response = $workService->request($request);
```

### EditGroupWelcomeTemplateRequest

```php
$request = EditGroupWelcomeTemplateRequest::createFromEntity($template);
$request->setTemplateId($templateId);
$response = $workService->request($request);
```

### DeleteGroupWelcomeTemplateRequest

```php
$request = new DeleteGroupWelcomeTemplateRequest();
$request->setTemplateId($templateId);
$request->setAgent($agent);
$response = $workService->request($request);
```

### GetGroupWelcomeTemplateRequest

```php
$request = new GetGroupWelcomeTemplateRequest();
$request->setTemplateId($templateId);
$request->setAgent($agent);
$response = $workService->request($request);
```

## 实体属性

`GroupWelcomeTemplate` 实体包含：

- **基本属性**: `agent`, `templateId`, `notify`
- **文本内容**: `textContent`
- **图片**: `imageMedia`, `imagePicUrl`
- **链接**: `linkTitle`, `linkUrl`, `linkDesc`, `linkPicUrl`
- **小程序**: `miniprogramTitle`, `miniprogramAppId`, `miniprogramPage`, `miniprogramMedia`
- **文件**: `fileMedia`
- **视频**: `videoMedia`
- **跟踪**: 创建/更新时间戳、用户追踪、IP 追踪

## 事件监听器

包含自动事件监听器：

- **prePersist**: 保存新实体时在企业微信中创建模板
- **preUpdate**: 修改实体时在企业微信中更新模板
- **postRemove**: 删除实体时从企业微信中删除模板

## 高级用法

### 自定义事件监听器

您可以创建自定义事件监听器以实现额外功能：

```php
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;

 #[AsEntityListener(event: Events::postPersist, method: 'postPersist')]
class CustomGroupWelcomeTemplateListener
{
    public function postPersist(GroupWelcomeTemplate $template): void
    {
        // 模板创建后的自定义逻辑
    }
}
```

### 扩展存储库

扩展存储库以实现自定义查询：

```php
use WechatWorkGroupWelcomeTemplateBundle\Repository\GroupWelcomeTemplateRepository;

class CustomGroupWelcomeTemplateRepository extends GroupWelcomeTemplateRepository
{
    public function findActiveTemplates(): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.sync = :sync')
            ->setParameter('sync', true)
            ->getQuery()
            ->getResult();
    }
}
```

### 批量操作

对于批量操作，您可以禁用自动同步：

```php
// 处理多个模板而不进行单独同步
foreach ($templates as $template) {
    $template->setSync(false); // 禁用自动同步
    $entityManager->persist($template);
}
$entityManager->flush();

// 手动一次性同步所有
$syncRequest = new BatchSyncGroupWelcomeTemplatesRequest();
// ... 配置并执行
```

## 测试

运行测试套件：

```bash
./vendor/bin/phpunit packages/wechat-work-group-welcome-template-bundle/tests
```

### 测试覆盖

包含全面的测试覆盖：

- **实体测试**: 测试 GroupWelcomeTemplate 实体属性和方法
- **存储库测试**: 测试存储库构造和基本功能
- **请求测试**: 测试 API 请求类和数据转换
- **事件监听器测试**: 测试与企业微信的自动同步
- **依赖注入测试**: 测试包配置和服务注册

## 系统要求

- PHP 8.1+
- Symfony 6.4+
- Doctrine ORM 3.0+
- tourze/wechat-work-bundle
- tourze/wechat-work-media-bundle

## 许可证

此包在 MIT 许可证下发布。详情请参阅捆绑的 LICENSE 文件。

## 参考文档

- [企业微信群欢迎语模板 API 文档](https://developer.work.weixin.qq.com/document/path/92366)
- [企业微信外部联系人 API](https://developer.work.weixin.qq.com/document/path/92366#添加入群欢迎语素材)