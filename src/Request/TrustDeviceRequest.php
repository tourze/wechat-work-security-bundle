<?php

namespace WechatWorkSecurityBundle\Request;

use HttpClientBundle\Request\ApiRequest;
use WechatWorkBundle\Request\AgentAware;

/**
 * 获取设备信息
 *
 * @see https://developer.work.weixin.qq.com/document/path/98920
 */
class TrustDeviceRequest extends ApiRequest
{
    use AgentAware;

    /**
     * @var int 查询设备类型
     */
    private int $type;

    public function getRequestPath(): string
    {
        return '/cgi-bin/security/trustdevice/list';
    }

    public function getRequestOptions(): ?array
    {
        return [
            'json' => [
                'type' => $this->getType(),
            ],
        ];
    }

    public function getRequestMethod(): ?string
    {
        return 'POST';
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function setType(int $type): void
    {
        $this->type = $type;
    }
}
