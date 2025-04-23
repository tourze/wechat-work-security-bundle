<?php

namespace WechatWorkSecurityBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use WechatWorkBundle\Repository\AgentRepository;
use WechatWorkBundle\Service\WorkService;
use WechatWorkSecurityBundle\Entity\TrustDevice;
use WechatWorkSecurityBundle\Enum\TrustDeviceSourceEnum;
use WechatWorkSecurityBundle\Enum\TrustDeviceStatusEnum;
use WechatWorkSecurityBundle\Request\TrustDeviceRequest;

/**
 * @see https://developer.work.weixin.qq.com/document/path/98920
 */
// #[AsCronTask('* * * * *')]
#[AsCommand(name: 'wechat-work:trust-device', description: '获取设备信息')]
class TrustDeviceCommand extends Command
{
    public function __construct(
        private readonly AgentRepository $agentRepository,
        private readonly WorkService $workService,
        private readonly EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $type = [1, 2, 3];
        foreach ($this->agentRepository->findAll() as $agent) {
            foreach ($type as $item) {
                $request = new TrustDeviceRequest();
                $request->setAgent($agent);
                $request->setType($item);

                $request = $this->workService->request($request);
                if (isset($request['errcode']) && 0 == $request['errcode']) {
                    foreach ($request['device_list'] as $device) {
                        $trustDevice = new TrustDevice();
                        $trustDevice->setType($item);
                        $trustDevice->setDeviceCode($device['device_code']);
                        $trustDevice->setSystem($device['system']);
                        $trustDevice->setSeqNo($device['seq_no']);
                        $trustDevice->setMacAddr($device['mac_addr'][0]);
                        $trustDevice->setSource(TrustDeviceSourceEnum::tryFrom($device['source']));
                        $trustDevice->setStatus(TrustDeviceStatusEnum::tryFrom($device['status']));
                        $trustDevice->setMotherboardUuid($device['motherboard_uuid']);
                        $trustDevice->setHarddiskUuid($device['harddisk_uuid'][0]);
                        $trustDevice->setDomain($device['domain']);
                        $trustDevice->setPcName($device['pc_name']);
                        $trustDevice->setLastLoginTime($device['last_login_time']);
                        $trustDevice->setLastLoginUserid($device['last_login_userid']);
                        $trustDevice->setConfirmTimestamp($device['confirm_timestamp']);
                        $trustDevice->setConfirmUserid($device['confirm_userid']);
                        $trustDevice->setApprovedUserid($device['approved_userid']);
                        $this->entityManager->persist($trustDevice);
                        $this->entityManager->flush();
                    }
                }
            }
        }

        return Command::SUCCESS;
    }
}
