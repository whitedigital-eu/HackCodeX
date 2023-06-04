<?php declare(strict_types = 1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\NotExposed;
use App\Enums\FormTypeEnum;
use App\Repository\FormRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FormRepository::class)]
#[ApiResource]
#[NotExposed]
#[ORM\Index(fields: ['formLetter'])]
class Form
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['submission_result:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 1)]
    #[Groups(['submission_result:read'])]
    private ?string $formLetter = null;

    #[ORM\Column(type: 'string', nullable: false, enumType: FormTypeEnum::class)]
    #[Groups(['submission_result:read'])]
    private ?FormTypeEnum $type = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['submission_result:read'])]
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
