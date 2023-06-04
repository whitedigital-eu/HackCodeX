<?php declare(strict_types = 1);

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\ExistsFilter;
use ApiPlatform\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Serializer\Filter\GroupFilter;
use App\Repository\SubmissionResultRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SubmissionResultRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['submission_result:read']])]
#[Get]
#[GetCollection]
#[ApiFilter(OrderFilter::class, properties: ['result'])]
#[ApiFilter(NumericFilter::class, properties: ['submission.id'])]
#[ApiFilter(ExistsFilter::class, properties: ['form.id', 'universityProgram.id', 'occupation.id'])]
#[ApiFilter(GroupFilter::class, arguments: ['parameterName' => 'groups', 'overrideDefaultGroups' => false])]
class SubmissionResult
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['submission_result:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['submission_result:read'])]
    #[ApiProperty(openapiContext: ['example' => '/api/submissions/1'])]
    private ?Submission $submission = null;

    #[ORM\ManyToOne]
    #[Groups(['submission_result:read'])]
    private ?Form $form = null;

    #[ORM\ManyToOne]
    #[Groups(['submission_result:read'])]
    private ?UniversityProgram $universityProgram = null;

    #[ORM\ManyToOne]
    #[Groups(['submission_result:read'])]
    private ?Occupation $occupation = null;

    #[ORM\Column]
    #[Groups(['submission_result:read'])]
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
