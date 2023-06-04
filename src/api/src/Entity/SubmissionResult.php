<?php declare(strict_types = 1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SubmissionResultRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubmissionResultRepository::class)]
#[ApiResource]
class SubmissionResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'submissionResults')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Submission $submission = null;

    #[ORM\ManyToOne]
    private ?Form $form = null;

    #[ORM\ManyToOne]
    private ?UniversityProgram $universityProgram = null;

    #[ORM\ManyToOne]
    private ?Occupation $occupation = null;

    #[ORM\Column]
    private ?int $result = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubmission(): ?Submission
    {
        return $this->submission;
    }

    public function setSubmission(?Submission $submission): static
    {
        $this->submission = $submission;

        return $this;
    }

    public function getForm(): ?Form
    {
        return $this->form;
    }

    public function setForm(?Form $form): static
    {
        $this->form = $form;

        return $this;
    }

    public function getUniversityProgram(): ?UniversityProgram
    {
        return $this->universityProgram;
    }

    public function setUniversityProgram(?UniversityProgram $universityProgram): static
    {
        $this->universityProgram = $universityProgram;

        return $this;
    }

    public function getOccupation(): ?Occupation
    {
        return $this->occupation;
    }

    public function setOccupation(?Occupation $occupation): static
    {
        $this->occupation = $occupation;

        return $this;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(int $result): static
    {
        $this->result = $result;

        return $this;
    }
}
