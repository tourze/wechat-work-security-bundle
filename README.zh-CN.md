# 企业微信安全管理包

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/wechat-work-security-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-work-security-bundle)
[![PHP Version](https://img.shields.io/packagist/php-v/tourze/wechat-work-security-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-work-security-bundle)
[![License](https://img.shields.io/packagist/l/tourze/wechat-work-security-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-work-security-bundle)
[![Build Status](https://img.shields.io/github/actions/workflow/status/tourze/monorepo/ci.yml?branch=main&style=flat-square)](https://github.com/tourze/monorepo/actions)
[![Coverage Status](https://img.shields.io/codecov/c/github/tourze/monorepo?style=flat-square)](https://codecov.io/gh/tourze/monorepo)

一个用于企业微信安全管理的 Symfony 包，提供全面的安全监控和控制功能。

## 目录

- [功能特性](#功能特性)
- [安装](#安装)
- [快速开始](#快速开始)
  - [配置](#配置)
  - [可用命令](#可用命令)
  - [定时执行](#定时执行)
- [高级用法](#高级用法)
  - [自定义命令配置](#自定义命令配置)
  - [实体自定义](#实体自定义)
  - [事件监听器](#事件监听器)
  - [API 集成](#api-集成)
- [配置选项](#配置选项)
  - [数据库配置](#数据库配置)
  - [定时任务配置](#定时任务配置)
- [实体](#实体)
- [系统要求](#系统要求)
- [依赖项](#依赖项)
- [贡献](#贡献)
- [许可证](#许可证)

## 功能特性

- **文件操作监控**：跟踪文件操作以防止数据泄漏
- **成员操作记录**：监控企业微信内的成员活动
- **截屏录屏管理**：跟踪截屏和录屏操作
- **可信设备管理**：管理和监控可信设备

## 安装

```bash
composer require tourze/wechat-work-security-bundle
```

## 快速开始

### 配置

在你的 Symfony 应用中配置此包：

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

## 可用命令

### 1. 文件操作记录命令

跟踪文件操作以防止数据泄漏：

```bash
php bin/console wechat-work:file-operate-record [--startTime=<datetime>] [--endTime=<datetime>]
```

**选项：**
- `--startTime`：记录的开始时间（默认：昨天开始时间）
- `--endTime`：记录的结束时间（默认：昨天结束时间）

**限制：**
- 时间范围不能超过 14 天
- 结束时间必须大于开始时间

### 2. 成员操作记录命令

获取成员操作记录：

```bash
php bin/console wechat-work:member-operate-record [--startTime=<datetime>] [--endTime=<datetime>]
```

**选项：**
- `--startTime`：记录的开始时间（默认：昨天开始时间）
- `--endTime`：记录的结束时间（默认：昨天结束时间）

**限制：**
- 开始时间不能早于 180 天前
- 结束时间必须大于开始时间且小于当前时间
- 时间范围不能超过 7 天

### 3. 截屏录屏记录命令

监控截屏和录屏操作：

```bash
php bin/console wechat-work:screen-operate-record [--startTime=<datetime>] [--endTime=<datetime>]
```

**选项：**
- `--startTime`：记录的开始时间（默认：昨天开始时间）
- `--endTime`：记录的结束时间（默认：昨天结束时间）

**限制：**
- 时间范围不能超过 14 天
- 结束时间必须大于开始时间

### 4. 可信设备命令

获取可信设备信息：

```bash
php bin/console wechat-work:trust-device
```

此命令获取所有类型的可信设备信息（类型 1、2 和 3），包括：
- MAC 地址
- 主板 UUID
- 硬盘 UUID
- 最后登录信息
- 审批和确认状态

### 定时执行

所有命令都可以使用 cron 表达式配置为定时任务。每个命令都有一个注释掉的 `AsCronTask` 属性，可以启用以实现自动执行。

每日执行的 crontab 示例：

```bash
0 1 * * * cd /path/to/app && php bin/console wechat-work:file-operate-record
0 2 * * * cd /path/to/app && php bin/console wechat-work:member-operate-record
0 3 * * * cd /path/to/app && php bin/console wechat-work:screen-operate-record
0 4 * * * cd /path/to/app && php bin/console wechat-work:trust-device
```

## 高级用法

### 自定义命令配置

你可以通过扩展提供的命令来自定义命令行为：

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

### 实体自定义

扩展实体以添加自定义字段：

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

### 事件监听器

监听安全事件：

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

### API 集成

直接与企业微信 API 集成：

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

## 配置选项

### 数据库配置

确保你的数据库支持 UTF-8 编码：

```yaml
doctrine:
    dbal:
        charset: utf8mb4
        default_table_options:
            charset: utf8mb4
            collate: utf8mb4_unicode_ci
```

### 定时任务配置

在生产环境中配置定时任务：

```bash
# 编辑 crontab
crontab -e

# 添加这些行
0 1 * * * cd /path/to/app && php bin/console wechat-work:file-operate-record
0 2 * * * cd /path/to/app && php bin/console wechat-work:member-operate-record
0 3 * * * cd /path/to/app && php bin/console wechat-work:screen-operate-record
0 4 * * * cd /path/to/app && php bin/console wechat-work:trust-device
```

## 实体

该包提供以下实体来存储安全相关数据：

- `FileOperateRecord`：存储文件操作记录
- `MemberOperateRecord`：存储成员操作记录
- `ScreenOperateRecord`：存储截屏/录屏记录
- `TrustDevice`：存储可信设备信息

## 系统要求

- PHP 8.1 或更高版本
- Symfony 6.4 或更高版本
- 企业微信包（`tourze/wechat-work-bundle`）
- Doctrine ORM 3.0 或更高版本

## 依赖项

此包依赖于：
- `tourze/wechat-work-bundle`：用于企业微信 API 集成
- `tourze/bundle-dependency`：用于管理包依赖关系
- `tourze/doctrine-timestamp-bundle`：用于自动时间戳管理
- `tourze/enum-extra`：用于增强的枚举支持
- `tourze/http-client-bundle`：用于 HTTP 客户端功能

## 贡献

详情请参阅 [CONTRIBUTING.md](CONTRIBUTING.md)。

## 许可证

MIT 许可证（MIT）。详情请参阅[许可证文件](LICENSE)。