<?php declare(strict_types = 1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Serializer\Filter\GroupFilter;
use App\Repository\SchoolRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(nullable: true)]
    #[Groups(['school:read'])]
    private ?string $address = null;

    #[ORM\Column(nullable: true)]
    private ?float $lat = null;

    #[ORM\Column(nullable: true)]
    private ?float $lon = null;

    #[ORM\OneToMany(targetEntity: Transport::class, mappedBy: 'school')]
    #[Groups(['school:read'])]
    private Collection $transports;

    public function __construct()
    {
        $this->transports = new ArrayCollection();
    }

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getLat(): ?float
    {
        return $this->lat;
    }

    public function setLat(?float $lat): self
    {
        $this->lat = $lat;

        return $this;
    }

    public function getLon(): ?float
    {
        return $this->lon;
    }

    public function setLon(?float $lon): self
    {
        $this->lon = $lon;

        return $this;
    }

    public function getTransports(): Collection
    {
        return $this->transports;
    }

    public function setTransports(Collection $transports): self
    {
        $this->transports = $transports;

        return $this;
    }

    public function addTransport(Transport $transport): self
    {
        if (!$this->transports->contains($transport)) {
            $this->transports->add($transport);
        }

        return $this;
    }

    public function removeTransport(Transport $transport): self
    {
        if ($this->transports->contains($transport)) {
            $this->transports->removeElement($transport);
        }

        return $this;
    }
}
