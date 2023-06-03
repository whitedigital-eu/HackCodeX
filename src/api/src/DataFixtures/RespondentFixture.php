<?php declare(strict_types = 1);

namespace App\DataFixtures;

use App\Entity\Respondent;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

use function random_int;
use function ucfirst;

class RespondentFixture extends AbstractFixture implements DependentFixtureInterface
{
    private const OPP = [
        'tangible' => 'intangible',
        'relationships' => 'identity',
        'retention' => 'discovery',
        'others' => 'self',
        'safety' => 'confidence',
        'concord' => 'control',
    ];

    public function load(ObjectManager $manager): void
    {
        function r(): int
        {
            return random_int(0, 10);
        }

        for ($i = 0; $i < 20_000; $i++) {
            $fixture = (new Respondent())
                ->setPragmatic(r())
                ->setDomestic(r())
                ->setTraditional(r())
                ->setPeaceful(r())
                ->setCaring(r())
                ->setTolerant(r())
                ->setContemplative(r())
                ->setInquisitive(r())
                ->setExperimental(r())
                ->setMaximalist(r())
                ->setDominant(r())
                ->setAmbitious(r())
                ->setLanguages(r())
                ->setSport(r())
                ->setMath(r())
                ->setPhysics(r())
                ->setGeography(r())
                ->setChemistry(r())
                ->setComputers(r())
                ->setMusic(r())
                ->setCrafts(r())
                ->setReligion(r())
                ->setArt(r());

            foreach (self::OPP as $item => $opposite) {
                $val = random_int(0, 10);
                if ($this->factory->boolean()) {
                    $fixture->{'set' . ucfirst($item)}($val);
                    $fixture->{'set' . ucfirst($opposite)}(0);
                } else {
                    $fixture->{'set' . ucfirst($opposite)}($val);
                    $fixture->{'set' . ucfirst($item)}(0);
                }
            }

            match (random_int(0, 2)) {
                0 => $fixture->setForm($this->getEntity(FormFixture::class)),
                1 => $fixture->setOccupation($this->getEntity(OccupationFixture::class)),
                2 => $fixture->setUniversityProgram($this->getEntity(UniversityProgramFixture::class)),
            };

            $manager->persist($fixture);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            OccupationFixture::class,
            UniversityProgramFixture::class,
            FormFixture::class,
        ];
    }
}
