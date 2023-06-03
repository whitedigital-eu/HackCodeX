<?php declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\UniversityProgram;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class UniversityProgramFixture extends AbstractFixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $processedProgrammes = [];
        if (($handle = fopen('/var/www/html/api/resources/university-majors.csv', 'rb')) !== false) {
            $i = -1;
            while (($data = fgetcsv($handle, 1000)) !== false) {
                $programName = trim($data[0]) . ' (' . trim($data[1]) . ')';
                if (!in_array($programName, $processedProgrammes, true)) {
                    $i++;
                    $entity = new UniversityProgram();
                    $entity->setTitle($programName);
                    $manager->persist($entity);
                    $processedProgrammes[] = $programName;

                    $manager->flush();

                    $this->addReference('university' . $i, $entity);
                    self::$references[self::class][] = 'university' . $i;
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
