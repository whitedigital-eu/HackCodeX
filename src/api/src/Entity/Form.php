<?php declare(strict_types = 1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\NotExposed;
use App\Repository\FormRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormRepository::class)]
#[ApiResource]
#[NotExposed]
#[ORM\Index(fields: ['formLetter'])]
#[ORM\Index(fields: ['school'])]
#[ORM\Index(fields: ['formNumber'])]
class Form
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $school = null;

    #[ORM\Column(length: 1)]
    private ?string $formLetter = null;

    #[ORM\Column]
    private ?int $formNumber = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSchool(): ?string
    {
        return $this->school;
    }

    public function setSchool(string $school): static
    {
        $this->school = $school;

        return $this;
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

    public function getFormNumber(): ?int
    {
        return $this->formNumber;
    }

    public function setFormNumber(int $formNumber): static
    {
        $this->formNumber = $formNumber;

        return $this;
    }
}
