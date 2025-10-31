<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Request;

use HttpClientBundle\Request\ApiRequest;
use WechatWorkBundle\Request\AgentAware;

/**
 * 获取文件防泄漏数据
 *
 * @see https://developer.work.weixin.qq.com/document/path/98079
 */
class FileOperateRecordRequest extends ApiRequest
{
    use AgentAware;

    /**
     * @var string 开始时间
     */
    private string $startTime;

    /**
     * @var int 结束时间
     */
    private int $endTime;

    /**
     * @var array<string> useridList
     */
    private array $useridList = [];

    /**
     * @var array<string>|null operation
     */
    private ?array $operation = null;

    /**
     * @var string cursor
     */
    private string $cursor;

    /**
     * @var int limit
     */
    private int $limit;

    public function getRequestPath(): string
    {
        return '/cgi-bin/security/get_file_oper_record';
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

    public function getEndTime(): int
    {
        return $this->endTime;
    }

    public function setEndTime(int $endTime): void
    {
        $this->endTime = $endTime;
    }

    /**
     * @return array<string>
     */
    public function getUseridList(): array
    {
        return $this->useridList;
    }

    /**
     * @param array<string> $useridList
     */
    public function setUseridList(array $useridList): void
    {
        $this->useridList = $useridList;
    }

    /**
     * @return array<string>|null
     */
    public function getOperation(): ?array
    {
        return $this->operation;
    }

    /**
     * @param array<string> $operation
     */
    public function setOperation(array $operation): void
    {
        $this->operation = $operation;
    }

    public function getCursor(): string
    {
        return $this->cursor;
    }

    public function setCursor(string $cursor): void
    {
        $this->cursor = $cursor;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function getStartTime(): string
    {
        return $this->startTime;
    }

    public function setStartTime(string $startTime): void
    {
        $this->startTime = $startTime;
    }
}
