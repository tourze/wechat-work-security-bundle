<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatWorkSecurityBundle\Entity\FileOperateRecord;
use WechatWorkSecurityBundle\Enum\FileOperateDeviceCodeEnum;

#[When(env: 'test')]
#[When(env: 'dev')]
class FileOperateRecordFixtures extends Fixture
{
    public const FILE_OPERATE_RECORD_REFERENCE_PREFIX = 'file_operate_record_';
    public const FILE_OPERATE_RECORD_COUNT = 15;

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('zh_CN');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::FILE_OPERATE_RECORD_COUNT; ++$i) {
            $record = $this->createFileOperateRecord();
            $manager->persist($record);
            $this->addReference(self::FILE_OPERATE_RECORD_REFERENCE_PREFIX . $i, $record);
        }

        $manager->flush();
    }

    private function createFileOperateRecord(): FileOperateRecord
    {
        $operations = ['download', 'upload', 'view', 'share', 'delete', 'approve_download', 'reject_download'];
        $systems = ['Windows', 'macOS', 'Linux'];

        $record = new FileOperateRecord();
        $record->setTime(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 year')));
        $record->setUserid('user_' . $this->faker->randomNumber(6));
        $record->setExternalUser($this->faker->optional()->userName);
        $record->setOperation($operations[array_rand($operations)]);
        $record->setFileInfo($this->faker->sentence(3) . '.pdf');
        $record->setFileMd5($this->faker->md5);
        $record->setFileSize($this->faker->numberBetween(1024, 52428800) . ' bytes');
        $record->setApplicantName($this->faker->optional()->name);
        $deviceTypes = FileOperateDeviceCodeEnum::cases();
        $record->setDeviceType($deviceTypes[array_rand($deviceTypes)]);
        $record->setDeviceCode('device_' . $this->faker->uuid);

        return $record;
    }
}
