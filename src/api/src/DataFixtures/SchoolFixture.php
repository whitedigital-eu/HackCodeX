<?php declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\School;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use function dirname;
use function file_get_contents;
use function json_decode;

class SchoolFixture extends AbstractFixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $path = dirname(__DIR__, 2) . '/resources/schools.json';
        $data = json_decode(file_get_contents($path), true);
        foreach ($data['Sheet1'] as $item) {
            if ('RĪGA' === $item['Pašvaldība']) {
                foreach ([7, 10] as $i) {
                    if ('0' !== $item[sprintf('%d. klase', $i)]) {
                        $entity = (new School())->setTitle($item['Iestādes nosaukums']);
                        $manager->persist($entity);
                        $manager->flush();
//                $this->addReference("school_{$entity->getId()}", $entity);
//                self::$references[self::class][] = "school_{$entity->getId()}";
                        break;
                    }
                }
            }
        }
    }

    public static function getGroups(): array
    {
        return ['schools'];
    }
}
