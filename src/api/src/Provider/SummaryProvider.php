<?php declare(strict_types = 1);

namespace App\Provider;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use App\ApiResource\SummaryResource;
use App\Entity\Form;
use App\Entity\Respondent;
use App\Entity\School;
use Doctrine\ORM\EntityManagerInterface;

class SummaryProvider implements ProviderInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $school = $this->em->getRepository(School::class)->find($uriVariables['school'] ?? null);
        $forms = $this->em->getRepository(Form::class)->findBy(['school' => $school]);
        $resource = new SummaryResource();
        $sum = 0;
        foreach ($forms as $form) {
            $respondents = $this->em->getRepository(Respondent::class)->findBy(['form' => $form]);
            foreach ($respondents as $respondent) {
                $sum++;
                $resource->languages += $respondent->getLanguages();
                $resource->sport += $respondent->getSport();
                $resource->math += $respondent->getMath();
                $resource->physics += $respondent->getPhysics();
                $resource->geography += $respondent->getGeography();
                $resource->chemistry += $respondent->getChemistry();
                $resource->computers += $respondent->getComputers();
                $resource->music += $respondent->getMusic();
                $resource->crafts += $respondent->getCrafts();
                $resource->religion += $respondent->getReligion();
                $resource->art += $respondent->getArt();
            }
        }

        $resource->languages = (int) round($resource->languages / $sum);
        $resource->sport = (int) round($resource->sport / $sum);
        $resource->math = (int) round($resource->math / $sum);
        $resource->physics = (int) round($resource->physics / $sum);
        $resource->geography = (int) round($resource->geography / $sum);
        $resource->chemistry = (int) round($resource->chemistry / $sum);
        $resource->computers = (int) round($resource->computers / $sum);
        $resource->music = (int) round($resource->music / $sum);
        $resource->crafts = (int) round($resource->crafts / $sum);
        $resource->religion = (int) round($resource->religion / $sum);
        $resource->art = (int) round($resource->art / $sum);

        return $resource;
    }
}
