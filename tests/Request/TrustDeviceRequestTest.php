<?php

namespace WechatWorkSecurityBundle\Tests\Request;

use HttpClientBundle\Request\ApiRequest;
use PHPUnit\Framework\TestCase;
use WechatWorkBundle\Request\AgentAware;
use WechatWorkSecurityBundle\Request\TrustDeviceRequest;

class TrustDeviceRequestTest extends TestCase
{
    private TrustDeviceRequest $request;

    protected function setUp(): void
    {
        $this->request = new TrustDeviceRequest();
    }

    public function test_extends_api_request(): void
    {
        $this->assertInstanceOf(ApiRequest::class, $this->request);
    }

    public function test_uses_agent_aware_trait(): void
    {
        $traits = class_uses(TrustDeviceRequest::class);
        $this->assertContains(AgentAware::class, $traits);
    }

    public function test_get_request_path_returns_correct_path(): void
    {
        $this->assertSame('/cgi-bin/security/trustdevice/list', $this->request->getRequestPath());
    }

    public function test_get_request_method_returns_post(): void
    {
        $this->assertSame('POST', $this->request->getRequestMethod());
    }

    public function test_type_getter_and_setter(): void
    {
        $type = 1;
        $this->request->setType($type);
        
        $this->assertSame($type, $this->request->getType());
    }

    public function test_get_request_options_with_required_fields(): void
    {
        $this->request->setType(2);

        $options = $this->request->getRequestOptions();
        $this->assertArrayHasKey('json', $options);
        $this->assertArrayHasKey('type', $options['json']);
        
        $this->assertSame(2, $options['json']['type']);
    }

    public function test_with_all_properties_set(): void
    {
        $this->request->setType(3);

        $this->assertSame(3, $this->request->getType());
    }

    public function test_type_with_different_values(): void
    {
        $types = [1, 2, 3, 0, 999];
        
        foreach ($types as $type) {
            $this->request->setType($type);
            $this->assertSame($type, $this->request->getType());
        }
    }
} 