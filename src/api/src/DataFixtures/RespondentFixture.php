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

        for ($i = 0; $i < 45000; $i++) {
            for ($j = 7; $j <= 12; $j++) {
                $fixture = new Respondent();
                $this->setForAll($fixture);
                $this->setForForm($fixture);
                $fixture->setForm($this->getForm($j));

                $manager->persist($fixture);
            }

            $manager->flush();
        }

        $manager->flush();

        for ($i = 0; $i < 45000; $i++) {
            $fixture = new Respondent();
            $this->setForAll($fixture);
            $fixture->setUniversityProgram($this->getEntity(UniversityProgramFixture::class));
            $manager->persist($fixture);
        }

        $manager->flush();

        for ($i = 0; $i < 45000; $i++) {
            $fixture = new Respondent();
            $this->setForAll($fixture);
            $fixture->setOccupation($this->getEntity(OccupationFixture::class));
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

    protected function getForm(int $form): ?object
    {
        return $this->getReference(FormFixture::$references[FormFixture::class][$form][$this->randomArrayKey(FormFixture::$references[FormFixture::class][$form])]);
    }

    private function setForAll(Respondent $respondent): void
    {
        $respondent
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
            ->setAmbitious(r());

        foreach (self::OPP as $item => $opposite) {
            $val = random_int(0, 10);
            if ($this->factory->boolean()) {
                $respondent->{'set' . ucfirst($item)}($val);
                $respondent->{'set' . ucfirst($opposite)}(0);
            } else {
                $respondent->{'set' . ucfirst($opposite)}($val);
                $respondent->{'set' . ucfirst($item)}(0);
            }
        }
    }

    private function setForForm(Respondent $respondent): void
    {
        $respondent
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
    }
}
