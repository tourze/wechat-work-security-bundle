<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WechatWorkBundle\Entity\Agent;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkSecurityBundle\Entity\TrustDevice;
use WechatWorkSecurityBundle\Enum\TrustDeviceSourceEnum;
use WechatWorkSecurityBundle\Enum\TrustDeviceStatusEnum;
use WechatWorkSecurityBundle\Request\TrustDeviceRequest;

/**
 * @see https://developer.work.weixin.qq.com/document/path/98920
 */
// #[AsCronTask(expression: '* * * * *')]
#[AsCommand(name: self::NAME, description: '获取设备信息')]
final class TrustDeviceCommand extends Command
{
    public const NAME = 'wechat-work:trust-device';

    public function __construct(
        private readonly AgentRepository $agentRepository,
        private readonly WorkService $workService,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $types = [1, 2, 3];

        /** @var list<Agent> $agents */
        $agents = $this->agentRepository->findAll();
        foreach ($agents as $agent) {
            $this->processAgentTypes($agent, $types);
        }

        return Command::SUCCESS;
    }

    /**
     * @param array<int> $types
     */
    private function processAgentTypes(Agent $agent, array $types): void
    {
        foreach ($types as $type) {
            $request = new TrustDeviceRequest();
            $request->setAgent($agent);
            $request->setType($type);

            $result = $this->workService->request($request);

            // 类型检查：确保 $result 是数组且包含期望的键
            if (is_array($result) && isset($result['errcode']) && 0 === $result['errcode']) {
                // 类型检查：确保 device_list 存在且是数组
                if (isset($result['device_list']) && is_array($result['device_list'])) {
                    $this->processDevices($result['device_list'], $type);
                }
            }
        }
    }

    /**
     * @param array<mixed> $devices
     */
    private function processDevices(array $devices, int $type): void
    {
        foreach ($devices as $device) {
            // 类型检查：确保 $device 是数组才能处理
            if (is_array($device)) {
                $trustDevice = $this->createTrustDevice($device, $type);
                $this->entityManager->persist($trustDevice);
            }
        }
        // 批量提交，提高性能
        $this->entityManager->flush();
    }

    /**
     * @param array<mixed> $device
     */
    private function createTrustDevice(array $device, int $type): TrustDevice
    {
        $trustDevice = new TrustDevice();
        $trustDevice->setType((string) $type);

        // 使用类型守卫确保数组访问安全，所有字段都可能有null值
        $trustDevice->setDeviceCode($this->getStringValue($device, 'device_code'));
        $trustDevice->setSystem($this->getStringValue($device, 'system'));
        $trustDevice->setSeqNo($this->getStringValue($device, 'seq_no'));
        $trustDevice->setMacAddr($this->getFirstArrayElement($device, 'mac_addr'));
        $trustDevice->setSource(TrustDeviceSourceEnum::tryFrom($this->getIntValue($device, 'source')));
        $trustDevice->setStatus(TrustDeviceStatusEnum::tryFrom($this->getIntValue($device, 'status')));
        $trustDevice->setMotherboardUuid($this->getStringValue($device, 'motherboard_uuid'));
        $trustDevice->setHarddiskUuid($this->getFirstArrayElement($device, 'harddisk_uuid'));
        $trustDevice->setDomain($this->getStringValue($device, 'domain'));
        $trustDevice->setPcName($this->getStringValue($device, 'pc_name'));
        $trustDevice->setLastLoginTime($this->getStringValue($device, 'last_login_time'));
        $trustDevice->setLastLoginUserid($this->getStringValue($device, 'last_login_userid'));
        $trustDevice->setConfirmTimestamp($this->getStringValue($device, 'confirm_timestamp'));
        $trustDevice->setConfirmUserid($this->getStringValue($device, 'confirm_userid'));
        $trustDevice->setApprovedUserid($this->getStringValue($device, 'approved_userid'));

        return $trustDevice;
    }

    /**
     * 安全获取字符串值
     *
     * @param array<mixed> $array
     */
    private function getStringValue(array $array, string $key): ?string
    {
        $value = $this->getMixedValue($array, $key);
        return is_string($value) ? $value : null;
    }

    /**
     * 安全获取整数值（用于枚举）
     *
     * @param array<mixed> $array
     * @return int|string
     */
    private function getIntValue(array $array, string $key): int|string
    {
        $value = $this->getMixedValue($array, $key);
        if (is_int($value)) {
            return $value;
        }
        if (is_string($value) && is_numeric($value)) {
            return (int) $value;
        }
        // 如果无法转换为整数，返回空字符串让 tryFrom 返回 null
        return '';
    }

    /**
     * 安全获取数组第一个元素
     *
     * @param array<mixed> $array
     */
    private function getFirstArrayElement(array $array, string $key): ?string
    {
        $value = $this->getMixedValue($array, $key);
        if (is_array($value) && count($value) > 0) {
            $firstElement = reset($value);
            return is_string($firstElement) ? $firstElement : null;
        }
        return null;
    }

    /**
     * 安全获取混合值
     *
     * @param array<mixed> $array
     * @return mixed
     */
    private function getMixedValue(array $array, string $key): mixed
    {
        return $array[$key] ?? null;
    }
}
