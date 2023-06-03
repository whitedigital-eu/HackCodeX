<?php declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\Form;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;

use function dirname;
use function file_get_contents;
use function json_decode;
use function random_int;
use function sprintf;

class FormFixture extends AbstractFixture implements FixtureGroupInterface
{
    private const LETTERS = ['a', 'b', 'c', 'd', ];

    public function load(ObjectManager $manager): void
    {
        $path = dirname(__DIR__, 2) . '/resources/schools.json';
        $data = json_decode(file_get_contents($path), true);
        $a = -1;
        foreach ($data['Sheet1'] as $item) {
            if ('RĪGA' === $item['Pašvaldība']) {
                for ($i = 7; $i <= 12; $i++) {
                    if ('0' !== $item[sprintf('%d. klase', $i)]) {
                        for ($j = 0; $j < random_int(1, 4); $j++) {
                            $a++;
                            $fixture = (new Form())
                                ->setFormNumber($i)
                                ->setSchool($item['Iestādes nosaukums'])
                                ->setFormLetter(self::LETTERS[$j]);
                            $manager->persist($fixture);
                            $manager->flush();

                            $this->addReference('form' . $a, $fixture);
                            self::$references[self::class][] = 'form' . $a;
                        }
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
