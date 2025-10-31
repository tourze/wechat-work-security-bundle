<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Request;

use HttpClientBundle\Request\ApiRequest;
use HttpClientBundle\Tests\Request\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use WechatWorkBundle\Request\AgentAware;
use WechatWorkSecurityBundle\Request\MemberOperateRecordRequest;

/**
 * @internal
 */
#[CoversClass(MemberOperateRecordRequest::class)]
final class MemberOperateRecordRequestTest extends RequestTestCase
{
    public function testExtendsApiRequest(): void
    {
        $request = new MemberOperateRecordRequest();
        $this->assertInstanceOf(ApiRequest::class, $request);
    }

    public function testUsesAgentAwareTrait(): void
    {
        $traits = class_uses(MemberOperateRecordRequest::class);
        $this->assertContains(AgentAware::class, $traits);
    }

    public function testGetRequestPathReturnsCorrectPath(): void
    {
        $request = new MemberOperateRecordRequest();
        $this->assertSame('/cgi-bin/security/member_oper_log/list', $request->getRequestPath());
    }

    public function testGetRequestMethodReturnsPost(): void
    {
        $request = new MemberOperateRecordRequest();
        $this->assertSame('POST', $request->getRequestMethod());
    }

    public function testStartTimeGetterAndSetter(): void
    {
        $request = new MemberOperateRecordRequest();
        $startTime = 1640995200;
        $request->setStartTime($startTime);

        $this->assertSame($startTime, $request->getStartTime());
    }

    public function testEndTimeGetterAndSetter(): void
    {
        $request = new MemberOperateRecordRequest();
        $endTime = 1640995260;
        $request->setEndTime($endTime);

        $this->assertSame($endTime, $request->getEndTime());
    }

    public function testGetRequestOptionsWithRequiredFields(): void
    {
        $request = new MemberOperateRecordRequest();
        $request->setStartTime(1640995200);
        $request->setEndTime(1640995260);

        $options = $request->getRequestOptions();
        $this->assertNotNull($options);
        $this->assertArrayHasKey('json', $options);
        $this->assertArrayHasKey('start_time', $options['json']);
        $this->assertArrayHasKey('end_time', $options['json']);

        $this->assertSame(1640995200, $options['json']['start_time']);
        $this->assertSame(1640995260, $options['json']['end_time']);
    }

    public function testWithAllPropertiesSet(): void
    {
        $request = new MemberOperateRecordRequest();
        $request->setStartTime(1640995200);
        $request->setEndTime(1640995260);

        $this->assertSame(1640995200, $request->getStartTime());
        $this->assertSame(1640995260, $request->getEndTime());
    }
}
