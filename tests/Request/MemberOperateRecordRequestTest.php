<?php

namespace WechatWorkSecurityBundle\Tests\Request;

use HttpClientBundle\Request\ApiRequest;
use PHPUnit\Framework\TestCase;
use WechatWorkBundle\Request\AgentAware;
use WechatWorkSecurityBundle\Request\MemberOperateRecordRequest;

class MemberOperateRecordRequestTest extends TestCase
{
    private MemberOperateRecordRequest $request;

    protected function setUp(): void
    {
        $this->request = new MemberOperateRecordRequest();
    }

    public function test_extends_api_request(): void
    {
        $this->assertInstanceOf(ApiRequest::class, $this->request);
    }

    public function test_uses_agent_aware_trait(): void
    {
        $traits = class_uses(MemberOperateRecordRequest::class);
        $this->assertContains(AgentAware::class, $traits);
    }

    public function test_get_request_path_returns_correct_path(): void
    {
        $this->assertSame('/cgi-bin/security/member_oper_log/list', $this->request->getRequestPath());
    }

    public function test_get_request_method_returns_post(): void
    {
        $this->assertSame('POST', $this->request->getRequestMethod());
    }

    public function test_start_time_getter_and_setter(): void
    {
        $startTime = 1640995200;
        $this->request->setStartTime($startTime);
        
        $this->assertSame($startTime, $this->request->getStartTime());
    }

    public function test_end_time_getter_and_setter(): void
    {
        $endTime = 1640995260;
        $this->request->setEndTime($endTime);
        
        $this->assertSame($endTime, $this->request->getEndTime());
    }

    public function test_get_request_options_with_required_fields(): void
    {
        $this->request->setStartTime(1640995200);
        $this->request->setEndTime(1640995260);

        $options = $this->request->getRequestOptions();
        
        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $this->assertArrayHasKey('start_time', $options['json']);
        $this->assertArrayHasKey('end_time', $options['json']);
        
        $this->assertSame(1640995200, $options['json']['start_time']);
        $this->assertSame(1640995260, $options['json']['end_time']);
    }

    public function test_with_all_properties_set(): void
    {
        $this->request->setStartTime(1640995200);
        $this->request->setEndTime(1640995260);

        $this->assertSame(1640995200, $this->request->getStartTime());
        $this->assertSame(1640995260, $this->request->getEndTime());
    }
} 