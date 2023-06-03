<?php

namespace App\DataFixtures;

use App\Entity\UniversityProgram;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UniversityProgramFixture extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $processedProgrammes = [];
        if (($handle = fopen("/var/www/html/api/resources/university-majors.csv", 'rb')) !== false) {
            while (($data = fgetcsv($handle, 1000)) !== false) {
                $programName = trim($data[0]) . ' (' . trim($data[1]) . ')';
                if (!in_array($programName, $processedProgrammes, true)) {
                    $entity = new UniversityProgram();
                    $entity->setTitle($programName);
                    $manager->persist($entity);
                    $processedProgrammes[] = $programName;
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
