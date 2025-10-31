# WeChat Work Security Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/wechat-work-security-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-work-security-bundle)
[![PHP Version](https://img.shields.io/packagist/php-v/tourze/wechat-work-security-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-work-security-bundle)
[![License](https://img.shields.io/packagist/l/tourze/wechat-work-security-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-work-security-bundle)
[![Build Status](https://img.shields.io/github/actions/workflow/status/tourze/monorepo/ci.yml?branch=main&style=flat-square)](https://github.com/tourze/monorepo/actions)
[![Coverage Status](https://img.shields.io/codecov/c/github/tourze/monorepo?style=flat-square)](https://codecov.io/gh/tourze/monorepo)

A Symfony bundle for WeChat Work (Enterprise WeChat) security management, providing 
comprehensive security monitoring and control features.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Quick Start](#quick-start)
  - [Configuration](#configuration)
  - [Available Commands](#available-commands)
  - [Scheduled Execution](#scheduled-execution)
- [Advanced Usage](#advanced-usage)
  - [Custom Command Configuration](#custom-command-configuration)
  - [Entity Customization](#entity-customization)
  - [Event Listeners](#event-listeners)
  - [API Integration](#api-integration)
- [Configuration Options](#configuration-options)
  - [Database Configuration](#database-configuration)
  - [Cron Configuration](#cron-configuration)
- [Entities](#entities)
- [Requirements](#requirements)
- [Dependencies](#dependencies)
- [Contributing](#contributing)
- [License](#license)

## Features

- **File Operation Monitoring**: Track file operations to prevent data leakage
- **Member Operation Recording**: Monitor member activities within WeChat Work
- **Screen Capture Management**: Track screen capture and recording operations
- **Device Trust Management**: Manage and monitor trusted devices

## Installation

```bash
composer require tourze/wechat-work-security-bundle
```

## Quick Start

### Configuration

Configure the bundle in your Symfony application:

```yaml
# config/packages/wechat_work_security.yaml
services:
    _defaults:
        autowire: true
        autoconfigure: true

    WechatWorkSecurityBundle\:
        resource: '../vendor/tourze/wechat-work-security-bundle/src/'
        exclude:
            - '../vendor/tourze/wechat-work-security-bundle/src/Entity/'
```

## Available Commands

### 1. File Operation Record Command

Track file operations to prevent data leakage:

```bash
php bin/console wechat-work:file-operate-record [--startTime=<datetime>] [--endTime=<datetime>]
```

**Options:**
- `--startTime`: Start time for records (default: beginning of yesterday)
- `--endTime`: End time for records (default: end of yesterday)

**Limitations:**
- Time range cannot exceed 14 days
- End time must be greater than start time

### 2. Member Operation Record Command

Get member operation records:

```bash
php bin/console wechat-work:member-operate-record [--startTime=<datetime>] [--endTime=<datetime>]
```

**Options:**
- `--startTime`: Start time for records (default: beginning of yesterday)
- `--endTime`: End time for records (default: end of yesterday)

**Limitations:**
- Start time cannot be earlier than 180 days ago
- End time must be greater than start time and less than current time
- Time range cannot exceed 7 days

### 3. Screen Operation Record Command

Monitor screen capture and recording operations:

```bash
php bin/console wechat-work:screen-operate-record [--startTime=<datetime>] [--endTime=<datetime>]
```

**Options:**
- `--startTime`: Start time for records (default: beginning of yesterday)
- `--endTime`: End time for records (default: end of yesterday)

**Limitations:**
- Time range cannot exceed 14 days
- End time must be greater than start time

### 4. Trust Device Command

Get information about trusted devices:

```bash
php bin/console wechat-work:trust-device
```

This command fetches information about all types of trusted devices (type 1, 2, and 3), including:
- MAC addresses
- Motherboard UUID
- Hard disk UUID
- Last login information
- Approval and confirmation status

### Scheduled Execution

All commands can be configured as scheduled tasks using cron expressions. Each command has a commented `AsCronTask` attribute that can be enabled for automatic execution.

Example crontab entry for daily execution:

```bash
0 1 * * * cd /path/to/app && php bin/console wechat-work:file-operate-record
0 2 * * * cd /path/to/app && php bin/console wechat-work:member-operate-record  
0 3 * * * cd /path/to/app && php bin/console wechat-work:screen-operate-record
0 4 * * * cd /path/to/app && php bin/console wechat-work:trust-device
```

## Advanced Usage

### Custom Command Configuration

You can customize command behavior by extending the provided commands:

```php
use WechatWorkSecurityBundle\Command\FileOperateRecordCommand;

class CustomFileOperateRecordCommand extends FileOperateRecordCommand
{
    protected function configure(): void
    {
        parent::configure();
        $this->setName('custom:file-operate-record');
    }
}
```

### Entity Customization

Extend entities to add custom fields:

```php
use WechatWorkSecurityBundle\Entity\FileOperateRecord;

class CustomFileOperateRecord extends FileOperateRecord
{
    private string $customField;
    
    public function getCustomField(): string
    {
        return $this->customField;
    }
}
```

### Event Listeners

Listen to security events:

```php
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SecurityEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            'wechat_work.file_operation' => 'onFileOperation',
        ];
    }
}
```

### API Integration

Integrate with WeChat Work API directly:

```php
use WechatWorkBundle\Service\WorkService;

class CustomSecurityService
{
    public function __construct(private WorkService $workService)
    {
    }
    
    public function getCustomSecurityData(): array
    {
        return $this->workService->request(/* custom request */);
    }
}
```

## Configuration Options

### Database Configuration

Ensure your database supports UTF-8 encoding:

```yaml
doctrine:
    dbal:
        charset: utf8mb4
        default_table_options:
            charset: utf8mb4
            collate: utf8mb4_unicode_ci
```

### Cron Configuration

For production environments, configure cron jobs:

```bash
# Edit crontab
crontab -e

# Add these lines
0 1 * * * cd /path/to/app && php bin/console wechat-work:file-operate-record
0 2 * * * cd /path/to/app && php bin/console wechat-work:member-operate-record
0 3 * * * cd /path/to/app && php bin/console wechat-work:screen-operate-record
0 4 * * * cd /path/to/app && php bin/console wechat-work:trust-device
```

## Entities

The bundle provides the following entities to store security-related data:

- `FileOperateRecord`: Stores file operation records
- `MemberOperateRecord`: Stores member operation records
- `ScreenOperateRecord`: Stores screen capture/recording records
- `TrustDevice`: Stores trusted device information

## Requirements

- PHP 8.1 or higher
- Symfony 6.4 or higher
- WeChat Work Bundle (`tourze/wechat-work-bundle`)
- Doctrine ORM 3.0 or higher

## Dependencies

This bundle depends on:
- `tourze/wechat-work-bundle`: For WeChat Work API integration
- `tourze/bundle-dependency`: For managing bundle dependencies
- `tourze/doctrine-timestamp-bundle`: For automatic timestamp management
- `tourze/enum-extra`: For enhanced enum support
- `tourze/http-client-bundle`: For HTTP client functionality

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.