<?php declare(strict_types = 1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Enums\TransportTypeEnum;
use Doctrine\ORM\Mapping as ORM;
use PhpSimple\Doctrine\Traits\Entity;
use PhpSimple\Doctrine\Traits\Id;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
#[ApiResource]
#[ORM\UniqueConstraint(fields: ['school', 'type', 'number'])]
class Transport
{
    use Id;

    #[ORM\Column(type: 'string', enumType: TransportTypeEnum::class)]
    #[Groups(['transport:read'])]
    private ?TransportTypeEnum $type = null;

    #[ORM\Column]
    #[Groups(['transport:read'])]
    private ?string $number = null;

    #[ORM\ManyToOne(targetEntity: School::class, inversedBy: 'transports')]
    private ?School $school = null;

    public function getType(): ?TransportTypeEnum
    {
        return $this->type;
    }

    public function setType(?TransportTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(?School $school): self
    {
        $this->school = $school;

        return $this;
    }
}
