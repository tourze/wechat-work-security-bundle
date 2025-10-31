<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Request;

use HttpClientBundle\Request\ApiRequest;
use WechatWorkBundle\Request\AgentAware;

/**
 * 获取成员操作记录
 *
 * @see https://developer.work.weixin.qq.com/document/path/100178
 */
class MemberOperateRecordRequest extends ApiRequest
{
    use AgentAware;

    /**
     * @var int 开始时间
     */
    private int $startTime;

    /**
     * @var int 结束时间
     */
    private int $endTime;

    public function getRequestPath(): string
    {
        return '/cgi-bin/security/member_oper_log/list';
    }

    public function getRequestOptions(): ?array
    {
        return [
            'json' => [
                'start_time' => $this->getStartTime(),
                'end_time' => $this->getEndTime(),
            ],
        ];
    }

    public function getRequestMethod(): ?string
    {
        return 'POST';
    }

    public function getStartTime(): int
    {
        return $this->startTime;
    }

    public function setStartTime(int $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getEndTime(): int
    {
        return $this->endTime;
    }

    public function setEndTime(int $endTime): void
    {
        $this->endTime = $endTime;
    }
}
