<?php declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\Occupation;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

class OccupationFixture extends AbstractFixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        if (($handle = fopen('/var/www/html/api/resources/occupation-classifiers.csv', 'rb')) !== false) {
            $i = -1;
            while (($data = fgetcsv($handle, 1000)) !== false) {
                if (7 === strlen($data[0])) {
                    $i++;
                    $entity = new Occupation();
                    $entity->setCode($data[0])->setTitle($data[1]);
                    $manager->persist($entity);
                    $manager->flush();

                    $this->addReference('occupation' . $i, $entity);
                    self::$references[self::class][] = 'occupation' . $i;
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
