<?php

namespace WechatWorkSecurityBundle\Tests\Request;

use PHPUnit\Framework\TestCase;
use WechatWorkBundle\Entity\Agent;
use WechatWorkSecurityBundle\Request\TrustDeviceRequest;

class TrustDeviceRequestTest extends TestCase
{
    private TrustDeviceRequest $request;

    protected function setUp(): void
    {
        $this->request = new TrustDeviceRequest();
    }

    public function testGetRequestPath_shouldReturnCorrectPath(): void
    {
        $expectedPath = '/cgi-bin/security/trustdevice/list';
        $this->assertSame($expectedPath, $this->request->getRequestPath());
    }

    public function testGetRequestMethod_shouldReturnPostMethod(): void
    {
        $this->assertSame('POST', $this->request->getRequestMethod());
    }

    public function testSetAndGetType_withValidValue_shouldReturnSameValue(): void
    {
        $type = 1;
        $this->request->setType($type);
        $this->assertSame($type, $this->request->getType());
    }

    public function testGetRequestOptions_withTypeSet_shouldIncludeTypeInJson(): void
    {
        // 设置type
        $type = 2;
        $this->request->setType($type);

        // 获取请求选项
        $options = $this->request->getRequestOptions();

        // 验证请求选项中包含正确的type值
        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $this->assertIsArray($options['json']);
        $this->assertArrayHasKey('type', $options['json']);
        $this->assertSame($type, $options['json']['type']);
    }

    public function testSetAndGetAgent_withValidValue_shouldReturnSameValue(): void
    {
        $agent = new Agent();
        $this->request->setAgent($agent);
        $this->assertSame($agent, $this->request->getAgent());
    }
}
