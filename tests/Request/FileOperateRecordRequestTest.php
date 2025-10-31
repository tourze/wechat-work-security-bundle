<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Request;

use HttpClientBundle\Request\ApiRequest;
use HttpClientBundle\Tests\Request\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use WechatWorkBundle\Request\AgentAware;
use WechatWorkSecurityBundle\Request\FileOperateRecordRequest;

/**
 * @internal
 */
#[CoversClass(FileOperateRecordRequest::class)]
final class FileOperateRecordRequestTest extends RequestTestCase
{
    public function testExtendsApiRequest(): void
    {
        $request = new FileOperateRecordRequest();
        $this->assertInstanceOf(ApiRequest::class, $request);
    }

    public function testUsesAgentAwareTrait(): void
    {
        $traits = class_uses(FileOperateRecordRequest::class);
        $this->assertContains(AgentAware::class, $traits);
    }

    public function testGetRequestPathReturnsCorrectPath(): void
    {
        $request = new FileOperateRecordRequest();
        $this->assertSame('/cgi-bin/security/get_file_oper_record', $request->getRequestPath());
    }

    public function testGetRequestMethodReturnsPost(): void
    {
        $request = new FileOperateRecordRequest();
        $this->assertSame('POST', $request->getRequestMethod());
    }

    public function testStartTimeGetterAndSetter(): void
    {
        $request = new FileOperateRecordRequest();
        $startTime = '1640995200';
        $request->setStartTime($startTime);

        $this->assertSame($startTime, $request->getStartTime());
    }

    public function testEndTimeGetterAndSetter(): void
    {
        $request = new FileOperateRecordRequest();
        $endTime = 1640995260;
        $request->setEndTime($endTime);

        $this->assertSame($endTime, $request->getEndTime());
    }

    public function testUseridListGetterAndSetter(): void
    {
        $request = new FileOperateRecordRequest();
        $this->assertSame([], $request->getUseridList());

        $useridList = ['user1', 'user2', 'user3'];
        $request->setUseridList($useridList);

        $this->assertSame($useridList, $request->getUseridList());
    }

    public function testOperationGetterAndSetter(): void
    {
        $request = new FileOperateRecordRequest();
        $operation = ['download', 'upload', 'view'];
        $request->setOperation($operation);

        $this->assertSame($operation, $request->getOperation());
    }

    public function testCursorGetterAndSetter(): void
    {
        $request = new FileOperateRecordRequest();
        $cursor = 'cursor_123';
        $request->setCursor($cursor);

        $this->assertSame($cursor, $request->getCursor());
    }

    public function testLimitGetterAndSetter(): void
    {
        $request = new FileOperateRecordRequest();
        $limit = 100;
        $request->setLimit($limit);

        $this->assertSame($limit, $request->getLimit());
    }

    public function testGetRequestOptionsWithRequiredFields(): void
    {
        $request = new FileOperateRecordRequest();
        $request->setStartTime('1640995200');
        $request->setEndTime(1640995260);

        $options = $request->getRequestOptions();
        $this->assertNotNull($options);
        $this->assertArrayHasKey('json', $options);
        $this->assertArrayHasKey('start_time', $options['json']);
        $this->assertArrayHasKey('end_time', $options['json']);

        $this->assertSame('1640995200', $options['json']['start_time']);
        $this->assertSame(1640995260, $options['json']['end_time']);
    }

    public function testWithAllPropertiesSet(): void
    {
        $request = new FileOperateRecordRequest();
        $request->setStartTime('1640995200');
        $request->setEndTime(1640995260);
        $request->setUseridList(['user1', 'user2']);
        $request->setOperation(['download', 'upload']);
        $request->setCursor('cursor_456');
        $request->setLimit(50);

        $this->assertSame('1640995200', $request->getStartTime());
        $this->assertSame(1640995260, $request->getEndTime());
        $this->assertSame(['user1', 'user2'], $request->getUseridList());
        $this->assertSame(['download', 'upload'], $request->getOperation());
        $this->assertSame('cursor_456', $request->getCursor());
        $this->assertSame(50, $request->getLimit());
    }
}
