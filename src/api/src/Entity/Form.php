<?php declare(strict_types = 1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Serializer\Filter\GroupFilter;
use App\Enums\FormTypeEnum;
use App\Repository\FormRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FormRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['form:read']])]
#[Get]
#[GetCollection]
#[ApiFilter(GroupFilter::class, arguments: ['parameterName' => 'groups', 'overrideDefaultGroups' => false])]
#[ORM\Index(fields: ['formLetter'])]
class Form
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['form:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 1)]
    #[Groups(['form:read'])]
    private ?string $formLetter = null;

    #[ORM\Column(type: 'string', nullable: false, enumType: FormTypeEnum::class)]
    #[Groups(['form:read'])]
    private ?FormTypeEnum $type = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['form:read'])]
    private ?School $school = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormLetter(): ?string
    {
        return $this->formLetter;
    }

    public function setFormLetter(string $formLetter): static
    {
        $this->formLetter = $formLetter;

        return $this;
    }

    public function getType(): ?FormTypeEnum
    {
        return $this->type;
    }

    public function setType(?FormTypeEnum $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSchool(): ?School
    {
        return $this->school;
    }

    public function setSchool(?School $school): static
    {
        $this->school = $school;

        return $this;
    }
}
