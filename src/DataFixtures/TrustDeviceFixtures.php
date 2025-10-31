<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatWorkSecurityBundle\Entity\TrustDevice;
use WechatWorkSecurityBundle\Enum\TrustDeviceSourceEnum;
use WechatWorkSecurityBundle\Enum\TrustDeviceStatusEnum;

#[When(env: 'test')]
#[When(env: 'dev')]
class TrustDeviceFixtures extends Fixture
{
    public const TRUST_DEVICE_REFERENCE_PREFIX = 'trust_device_';
    public const TRUST_DEVICE_COUNT = 10;

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('zh_CN');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::TRUST_DEVICE_COUNT; ++$i) {
            $device = $this->createTrustDevice();
            $manager->persist($device);
            $this->addReference(self::TRUST_DEVICE_REFERENCE_PREFIX . $i, $device);
        }

        $manager->flush();
    }

    private function createTrustDevice(): TrustDevice
    {
        $deviceTypes = ['pc', 'mobile', 'tablet'];
        $systems = ['Windows 10', 'Windows 11', 'macOS', 'iOS', 'Android', 'Linux'];
        $domains = ['WORKGROUP', 'COMPANY', 'ENTERPRISE'];

        $device = new TrustDevice();

        /** @var string $type */
        $type = $this->faker->randomElement($deviceTypes);
        $device->setType($type);

        $device->setDeviceCode('device_' . $this->faker->uuid);

        /** @var string $system */
        $system = $this->faker->randomElement($systems);
        $device->setSystem($system);

        $device->setMacAddr($this->faker->macAddress);
        $device->setMotherboardUuid($this->faker->uuid);
        $device->setHarddiskUuid($this->faker->uuid);

        /** @var string $domain */
        $domain = $this->faker->randomElement($domains);
        $device->setDomain($domain);

        $device->setPcName($this->faker->userName . '-PC');
        $device->setSeqNo($this->faker->regexify('[A-Z0-9]{10}'));
        $device->setLastLoginTime((string) $this->faker->unixTime);
        $device->setLastLoginUserid('user_' . $this->faker->randomNumber(6));
        $device->setConfirmTimestamp((string) $this->faker->unixTime);
        $device->setConfirmUserid('admin_' . $this->faker->randomNumber(4));
        $device->setApprovedUserid('admin_' . $this->faker->randomNumber(4));

        /** @var TrustDeviceSourceEnum $source */
        $source = $this->faker->randomElement(TrustDeviceSourceEnum::cases());
        $device->setSource($source);

        /** @var TrustDeviceStatusEnum $status */
        $status = $this->faker->randomElement(TrustDeviceStatusEnum::cases());
        $device->setStatus($status);

        return $device;
    }
}
