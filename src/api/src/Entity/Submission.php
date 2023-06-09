<?php declare(strict_types = 1);

namespace App\Entity;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Serializer\Filter\GroupFilter;
use App\Enums\SubmissionTypeEnum;
use App\Processors\SubmissionProcessor;
use App\Repository\SubmissionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SubmissionRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['submission:read']], denormalizationContext: ['groups' => ['submission:write']], processor: SubmissionProcessor::class)]
#[ApiFilter(GroupFilter::class, arguments: ['parameterName' => 'groups', 'overrideDefaultGroups' => false])]
class Submission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['submission:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', nullable: false, enumType: SubmissionTypeEnum::class)]
    #[Groups(['submission:read', 'submission:write'])]
    private ?SubmissionTypeEnum $type = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $pragmatic = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $domestic = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $traditional = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $peaceful = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $caring = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $tolerant = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $contemplative = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $inquisitive = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $experimental = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $maximalist = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $dominant = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $ambitious = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $tangible = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $intangible = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $relationships = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $identity = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $retention = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $discovery = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $others = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $self = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $safety = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $confidence = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $concord = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $control = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $languages = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $sport = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $math = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $physics = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $geography = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $chemistry = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $computers = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $music = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $crafts = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $religion = null;

    #[ORM\Column]
    #[Groups(['submission:read', 'submission:write'])]
    private ?int $art = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?SubmissionTypeEnum
    {
        return $this->type;
    }

    public function setType(SubmissionTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPragmatic(): ?int
    {
        return $this->pragmatic;
    }

    public function setPragmatic(int $pragmatic): static
    {
        $this->pragmatic = $pragmatic;

        return $this;
    }

    public function getDomestic(): ?int
    {
        return $this->domestic;
    }

    public function setDomestic(int $domestic): static
    {
        $this->domestic = $domestic;

        return $this;
    }

    public function getTraditional(): ?int
    {
        return $this->traditional;
    }

    public function setTraditional(int $traditional): static
    {
        $this->traditional = $traditional;

        return $this;
    }

    public function getPeaceful(): ?int
    {
        return $this->peaceful;
    }

    public function setPeaceful(int $peaceful): static
    {
        $this->peaceful = $peaceful;

        return $this;
    }

    public function getCaring(): ?int
    {
        return $this->caring;
    }

    public function setCaring(int $caring): static
    {
        $this->caring = $caring;

        return $this;
    }

    public function getTolerant(): ?int
    {
        return $this->tolerant;
    }

    public function setTolerant(int $tolerant): static
    {
        $this->tolerant = $tolerant;

        return $this;
    }

    public function getContemplative(): ?int
    {
        return $this->contemplative;
    }

    public function setContemplative(int $contemplative): static
    {
        $this->contemplative = $contemplative;

        return $this;
    }

    public function getInquisitive(): ?int
    {
        return $this->inquisitive;
    }

    public function setInquisitive(int $inquisitive): static
    {
        $this->inquisitive = $inquisitive;

        return $this;
    }

    public function getExperimental(): ?int
    {
        return $this->experimental;
    }

    public function setExperimental(int $experimental): static
    {
        $this->experimental = $experimental;

        return $this;
    }

    public function getMaximalist(): ?int
    {
        return $this->maximalist;
    }

    public function setMaximalist(int $maximalist): static
    {
        $this->maximalist = $maximalist;

        return $this;
    }

    public function getDominant(): ?int
    {
        return $this->dominant;
    }

    public function setDominant(int $dominant): static
    {
        $this->dominant = $dominant;

        return $this;
    }

    public function getAmbitious(): ?int
    {
        return $this->ambitious;
    }

    public function setAmbitious(int $ambitious): static
    {
        $this->ambitious = $ambitious;

        return $this;
    }

    public function getTangible(): ?int
    {
        return $this->tangible;
    }

    public function setTangible(int $tangible): static
    {
        $this->tangible = $tangible;

        return $this;
    }

    public function getIntangible(): ?int
    {
        return $this->intangible;
    }

    public function setIntangible(int $intangible): static
    {
        $this->intangible = $intangible;

        return $this;
    }

    public function getRelationships(): ?int
    {
        return $this->relationships;
    }

    public function setRelationships(int $relationships): static
    {
        $this->relationships = $relationships;

        return $this;
    }

    public function getIdentity(): ?int
    {
        return $this->identity;
    }

    public function setIdentity(int $identity): static
    {
        $this->identity = $identity;

        return $this;
    }

    public function getRetention(): ?int
    {
        return $this->retention;
    }

    public function setRetention(int $retention): static
    {
        $this->retention = $retention;

        return $this;
    }

    public function getDiscovery(): ?int
    {
        return $this->discovery;
    }

    public function setDiscovery(int $discovery): static
    {
        $this->discovery = $discovery;

        return $this;
    }

    public function getOthers(): ?int
    {
        return $this->others;
    }

    public function setOthers(int $others): static
    {
        $this->others = $others;

        return $this;
    }

    public function getSelf(): ?int
    {
        return $this->self;
    }

    public function setSelf(int $self): static
    {
        $this->self = $self;

        return $this;
    }

    public function getSafety(): ?int
    {
        return $this->safety;
    }

    public function setSafety(int $safety): static
    {
        $this->safety = $safety;

        return $this;
    }

    public function getConfidence(): ?int
    {
        return $this->confidence;
    }

    public function setConfidence(int $confidence): static
    {
        $this->confidence = $confidence;

        return $this;
    }

    public function getConcord(): ?int
    {
        return $this->concord;
    }

    public function setConcord(int $concord): static
    {
        $this->concord = $concord;

        return $this;
    }

    public function getControl(): ?int
    {
        return $this->control;
    }

    public function setControl(int $control): static
    {
        $this->control = $control;

        return $this;
    }

    public function getLanguages(): ?int
    {
        return $this->languages;
    }

    public function setLanguages(int $languages): static
    {
        $this->languages = $languages;

        return $this;
    }

    public function getSport(): ?int
    {
        return $this->sport;
    }

    public function setSport(int $sport): static
    {
        $this->sport = $sport;

        return $this;
    }

    public function getMath(): ?int
    {
        return $this->math;
    }

    public function setMath(int $math): static
    {
        $this->math = $math;

        return $this;
    }

    public function getPhysics(): ?int
    {
        return $this->physics;
    }

    public function setPhysics(int $physics): static
    {
        $this->physics = $physics;

        return $this;
    }

    public function getGeography(): ?int
    {
        return $this->geography;
    }

    public function setGeography(int $geography): static
    {
        $this->geography = $geography;

        return $this;
    }

    public function getChemistry(): ?int
    {
        return $this->chemistry;
    }

    public function setChemistry(int $chemistry): static
    {
        $this->chemistry = $chemistry;

        return $this;
    }

    public function getComputers(): ?int
    {
        return $this->computers;
    }

    public function setComputers(int $computers): static
    {
        $this->computers = $computers;

        return $this;
    }

    public function getMusic(): ?int
    {
        return $this->music;
    }

    public function setMusic(int $music): static
    {
        $this->music = $music;

        return $this;
    }

    public function getCrafts(): ?int
    {
        return $this->crafts;
    }

    public function setCrafts(int $crafts): static
    {
        $this->crafts = $crafts;

        return $this;
    }

    public function getReligion(): ?int
    {
        return $this->religion;
    }

    public function setReligion(int $religion): static
    {
        $this->religion = $religion;

        return $this;
    }

    public function getArt(): ?int
    {
        return $this->art;
    }

    public function setArt(int $art): static
    {
        $this->art = $art;

        return $this;
    }
}
