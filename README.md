# WechatWork Group Welcome Template Bundle

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.1-blue.svg)](https://php.net/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)
[![Symfony](https://img.shields.io/badge/symfony-%3E%3D6.4-black.svg)](https://symfony.com/)
[![Build Status](https://img.shields.io/badge/build-passing-brightgreen.svg)](https://github.com/tourze/php-monorepo)
[![Code Coverage](https://img.shields.io/badge/coverage-98%25-brightgreen.svg)](https://github.com/tourze/php-monorepo)

[English](README.md) | [中文](README.zh-CN.md)

A Symfony bundle for managing WeChat Work group welcome templates. This bundle provides entities, 
repositories, and API requests for creating, editing, and managing welcome messages that are sent 
to new group members.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Configuration](#configuration)
- [API Requests](#api-requests)
- [Entity Properties](#entity-properties)
- [Event Listeners](#event-listeners)
- [Advanced Usage](#advanced-usage)
- [Testing](#testing)
- [Requirements](#requirements)
- [License](#license)
- [References](#references)

## Features

- **Entity Management**: Doctrine ORM entities for group welcome templates
- **API Integration**: Request classes for WeChat Work external contact API
- **Rich Content Support**: Support for text, images, links, mini-programs, files, and videos
- **Automatic Sync**: Event listeners for automatic synchronization with WeChat Work
- **Comprehensive Testing**: Full test coverage with PHPUnit

## Installation

Install the bundle via Composer:

```bash
composer require tourze/wechat-work-group-welcome-template-bundle
```

## Quick Start

### 1. Create a Group Welcome Template

```php
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;
use WechatWorkGroupWelcomeTemplateBundle\Request\AddGroupWelcomeTemplateRequest;

// Create a new template entity
$template = new GroupWelcomeTemplate();
$template->setAgent($agent); // Your WeChat Work agent
$template->setNotify(true);
$template->setTextContent('Welcome to our group!');
$template->setSync(true); // Enable automatic sync

// Save to database (will automatically sync to WeChat Work)
$entityManager->persist($template);
$entityManager->flush();
```

### 2. Create API Request Manually

```php
use WechatWorkGroupWelcomeTemplateBundle\Request\AddGroupWelcomeTemplateRequest;

$request = new AddGroupWelcomeTemplateRequest();
$request->setAgent($agent);
$request->setNotify(true);
$request->setTextContent('Welcome to our team!');
$request->setLinkTitle('Learn More');
$request->setLinkUrl('https://example.com');
$request->setLinkDesc('Click to learn more about our company');

// Use with WorkService
$response = $workService->request($request);
```

### 3. Rich Content Templates

```php
$template = new GroupWelcomeTemplate();
$template->setAgent($agent);
$template->setNotify(true);

// Text content
$template->setTextContent('Welcome! Here are some resources:');

// Image
$template->setImageMedia($imageMedia); // TempMedia entity
// or
$template->setImagePicUrl('https://example.com/welcome.jpg');

// Link
$template->setLinkTitle('Company Website');
$template->setLinkUrl('https://company.com');
$template->setLinkDesc('Visit our website');
$template->setLinkPicUrl('https://company.com/logo.jpg');

// Mini-program
$template->setMiniprogramTitle('Team Tool');
$template->setMiniprogramAppId('wxabcd1234');
$template->setMiniprogramPage('pages/welcome');
$template->setMiniprogramMedia($miniprogramMedia);

// File
$template->setFileMedia($fileMedia);

// Video
$template->setVideoMedia($videoMedia);
```

## Configuration

The bundle automatically configures services. No additional configuration is required.

### Service Configuration

Services are automatically registered:
- `WechatWorkGroupWelcomeTemplateBundle\Repository\GroupWelcomeTemplateRepository`
- `WechatWorkGroupWelcomeTemplateBundle\EventSubscriber\GroupWelcomeTemplateListener`

## API Requests

The bundle provides several request classes for WeChat Work API:

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

## Entity Properties

The `GroupWelcomeTemplate` entity includes:

- **Basic Properties**: `agent`, `templateId`, `notify`
- **Text Content**: `textContent`
- **Image**: `imageMedia`, `imagePicUrl`
- **Link**: `linkTitle`, `linkUrl`, `linkDesc`, `linkPicUrl`
- **Mini-program**: `miniprogramTitle`, `miniprogramAppId`, `miniprogramPage`, `miniprogramMedia`
- **File**: `fileMedia`
- **Video**: `videoMedia`
- **Tracking**: Created/updated timestamps, user blame, IP tracking

## Event Listeners

The bundle includes automatic event listeners:

- **prePersist**: Creates template in WeChat Work when saving new entities
- **preUpdate**: Updates template in WeChat Work when modifying entities
- **postRemove**: Deletes template from WeChat Work when removing entities

## Advanced Usage

### Custom Event Listeners

You can create custom event listeners for additional functionality:

```php
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use WechatWorkGroupWelcomeTemplateBundle\Entity\GroupWelcomeTemplate;

 #[AsEntityListener(event: Events::postPersist, method: 'postPersist')]
class CustomGroupWelcomeTemplateListener
{
    public function postPersist(GroupWelcomeTemplate $template): void
    {
        // Custom logic after template creation
    }
}
```

### Repository Extensions

Extend the repository for custom queries:

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

### Batch Operations

For bulk operations, you can disable automatic sync:

```php
// Process multiple templates without individual sync
foreach ($templates as $template) {
    $template->setSync(false); // Disable auto-sync
    $entityManager->persist($template);
}
$entityManager->flush();

// Manually sync all at once
$syncRequest = new BatchSyncGroupWelcomeTemplatesRequest();
// ... configure and execute
```

## Testing

Run the test suite:

```bash
./vendor/bin/phpunit packages/wechat-work-group-welcome-template-bundle/tests
```

### Test Coverage

The bundle includes comprehensive test coverage:

- **Entity Tests**: Test GroupWelcomeTemplate entity properties and methods
- **Repository Tests**: Test repository construction and basic functionality
- **Request Tests**: Test API request classes and data transformation
- **Event Listener Tests**: Test automatic synchronization with WeChat Work
- **Dependency Injection Tests**: Test bundle configuration and service registration

## Requirements

- PHP 8.1+
- Symfony 6.4+
- Doctrine ORM 3.0+
- tourze/wechat-work-bundle
- tourze/wechat-work-media-bundle

## License

This bundle is released under the MIT License. See the bundled LICENSE file for details.

## References

- [WeChat Work Group Welcome Template API Documentation](https://developer.work.weixin.qq.com/document/path/92366)
- [WeChat Work External Contact API](https://developer.work.weixin.qq.com/document/path/92366#添加入群欢迎语素材)