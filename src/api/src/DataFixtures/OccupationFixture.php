<?php

namespace App\DataFixtures;

use App\Entity\Occupation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class OccupationFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        if (($handle = fopen("/var/www/html/api/resources/prof-klasifikators.csv", 'rb')) !== false) {
            while (($data = fgetcsv($handle, 1000)) !== false) {
                if (strlen($data[0]) === 7) {
                    $entity = new Occupation();
                    $entity->setCode($data[0])->setTitle($data[1]);
                    $manager->persist($entity);
                }
            }
            fclose($handle);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['default'];
    }
}
