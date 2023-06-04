<?php declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Serializer\Filter\GroupFilter;
use App\Repository\SchoolRepository;
use Doctrine\ORM\Mapping as ORM;
use Faker\Factory;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SchoolRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['school:read']])]
#[Get]
#[GetCollection]
#[ApiFilter(GroupFilter::class, arguments: ['parameterName' => 'groups', 'overrideDefaultGroups' => false])]
class School
{
    protected const EXTRA_CURRICULAR_ACTIVITIES = [
        'dejošana',
        'dziedāšana',
        'sports',
        'šahs',
        'peldēšana',
        'lidmodelisms',
        'šūšana',
        'robotika',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['school:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['school:read'])]
    private ?string $title = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string[]
     */
    #[Groups(['school:read'])]
    public function getExtraCurricularActivities(): array
    {
        $factory = Factory::create('en_US');
        $factory->seed($this->id);
        $array = $factory->shuffleArray(self::EXTRA_CURRICULAR_ACTIVITIES);
        return array_slice($array, 0, 3);
    }
}
