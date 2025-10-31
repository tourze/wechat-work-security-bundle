<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Tests\Request;

use HttpClientBundle\Request\ApiRequest;
use HttpClientBundle\Tests\Request\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use WechatWorkBundle\Request\AgentAware;
use WechatWorkSecurityBundle\Request\TrustDeviceRequest;

/**
 * @internal
 */
#[CoversClass(TrustDeviceRequest::class)]
final class TrustDeviceRequestTest extends RequestTestCase
{
    public function testExtendsApiRequest(): void
    {
        $request = new TrustDeviceRequest();
        $this->assertInstanceOf(ApiRequest::class, $request);
    }

    public function testUsesAgentAwareTrait(): void
    {
        $traits = class_uses(TrustDeviceRequest::class);
        $this->assertContains(AgentAware::class, $traits);
    }

    public function testGetRequestPathReturnsCorrectPath(): void
    {
        $request = new TrustDeviceRequest();
        $this->assertSame('/cgi-bin/security/trustdevice/list', $request->getRequestPath());
    }

    public function testGetRequestMethodReturnsPost(): void
    {
        $request = new TrustDeviceRequest();
        $this->assertSame('POST', $request->getRequestMethod());
    }

    public function testTypeGetterAndSetter(): void
    {
        $request = new TrustDeviceRequest();
        $type = 1;
        $request->setType($type);

        $this->assertSame($type, $request->getType());
    }

    public function testGetRequestOptionsWithRequiredFields(): void
    {
        $request = new TrustDeviceRequest();
        $request->setType(2);

        $options = $request->getRequestOptions();
        $this->assertNotNull($options);
        $this->assertArrayHasKey('json', $options);
        $this->assertArrayHasKey('type', $options['json']);

        $this->assertSame(2, $options['json']['type']);
    }

    public function testWithAllPropertiesSet(): void
    {
        $request = new TrustDeviceRequest();
        $request->setType(3);

        $this->assertSame(3, $request->getType());
    }

    public function testTypeWithDifferentValues(): void
    {
        $request = new TrustDeviceRequest();
        $types = [1, 2, 3, 0, 999];

        foreach ($types as $type) {
            $request->setType($type);
            $this->assertSame($type, $request->getType());
        }
    }
}
