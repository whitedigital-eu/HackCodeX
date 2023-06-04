<?php declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use PhpSimple\Doctrine\Traits\Id;

#[ORM\Entity]
#[ORM\UniqueConstraint(fields: ['school', 'stopId'])]
#[ORM\Index(fields: ['stopId'])]
class TransportStop
{
    use Id;

    #[ORM\Column]
    private ?string $stopId = null;

    #[ORM\ManyToOne(targetEntity: School::class)]
    private ?School $school = null;

    public function getStopId(): ?string
    {
        return $this->stopId;
    }

    public function setStopId(?string $stopId): self
    {
        $this->stopId = $stopId;

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
