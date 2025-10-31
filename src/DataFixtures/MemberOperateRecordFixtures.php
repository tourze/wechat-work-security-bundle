<?php

declare(strict_types=1);

namespace WechatWorkSecurityBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatWorkSecurityBundle\Entity\MemberOperateRecord;

#[When(env: 'test')]
#[When(env: 'dev')]
class MemberOperateRecordFixtures extends Fixture
{
    public const MEMBER_OPERATE_RECORD_REFERENCE_PREFIX = 'member_operate_record_';
    public const MEMBER_OPERATE_RECORD_COUNT = 20;

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('zh_CN');
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::MEMBER_OPERATE_RECORD_COUNT; ++$i) {
            $record = $this->createMemberOperateRecord();
            $manager->persist($record);
            $this->addReference(self::MEMBER_OPERATE_RECORD_REFERENCE_PREFIX . $i, $record);
        }

        $manager->flush();
    }

    private function createMemberOperateRecord(): MemberOperateRecord
    {
        $operTypes = ['login', 'logout', 'create_group', 'add_member', 'remove_member', 'send_message', 'file_share'];

        $record = new MemberOperateRecord();
        $record->setTime(\DateTimeImmutable::createFromMutable($this->faker->dateTimeBetween('-1 year')));
        $record->setUserid('user_' . $this->faker->randomNumber(6));
        $record->setOperType($operTypes[array_rand($operTypes)]);
        $record->setDetailInfo($this->faker->sentence(5));
        $record->setIp($this->faker->ipv4);

        return $record;
    }
}
