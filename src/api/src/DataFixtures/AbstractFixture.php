<?php declare(strict_types = 1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Faker\Generator;
use Random\Randomizer;

abstract class AbstractFixture extends Fixture
{
    public static array $references;
    protected readonly Generator $factory;

    public function __construct()
    {
//        $this->factory = Factory::create('en_US');
//        $this->factory->seed($_ENV['SEED'] ?? 2022);
    }

    protected function randomArrayKey(array $array): mixed
    {
        return (new Randomizer())->pickArrayKeys(array: $array, num: 1)[0];
    }
}
