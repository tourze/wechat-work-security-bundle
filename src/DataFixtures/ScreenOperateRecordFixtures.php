<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatWorkSecurityBundle\Entity\ScreenOperateRecord;
use WechatWorkSecurityBundle\Enum\ScreenShotTypeEnum;

#[When(env: 'test')]
#[When(env: 'dev')]
class ScreenOperateRecordFixtures extends Fixture
{
    public const SCREEN_OPERATE_RECORD_REFERENCE_PREFIX = 'screen_operate_record_';
    public const SCREEN_OPERATE_RECORD_COUNT = 12;

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('zh_CN');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::SCREEN_OPERATE_RECORD_COUNT; ++$i) {
            $record = $this->createScreenOperateRecord();
            $manager->persist($record);
            $this->addReference(self::SCREEN_OPERATE_RECORD_REFERENCE_PREFIX . $i, $record);
        }

        $manager->flush();
    }

    private function createScreenOperateRecord(): ScreenOperateRecord
    {
        $systems = ['Windows 10', 'Windows 11', 'macOS Big Sur', 'macOS Monterey', 'Ubuntu 20.04'];

        $record = new ScreenOperateRecord();
        $record->setTime(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 year')));
        $record->setUserid('user_' . $this->faker->randomNumber(6));
        $record->setDepartmentId($this->faker->numberBetween(1, 100));
        $screenShotTypes = ScreenShotTypeEnum::cases();
        $record->setScreenShotType($screenShotTypes[array_rand($screenShotTypes)]);
        $record->setScreenShotContent($this->faker->sentence(3));
        $record->setSystem($systems[array_rand($systems)]);

        return $record;
    }
}
