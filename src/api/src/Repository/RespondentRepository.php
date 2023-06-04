<?php declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Respondent;
use App\Entity\Submission;
use App\Enums\FormTypeEnum;
use App\Enums\SubmissionTypeEnum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Respondent>
 *
 * @method Respondent|null find($id, $lockMode = null, $lockVersion = null)
 * @method Respondent|null findOneBy(array $criteria, array $orderBy = null)
 * @method Respondent[]    findAll()
 * @method Respondent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RespondentRepository extends ServiceEntityRepository
{
    public const ATTRS = [
        'pragmatic',
        'domestic',
        'traditional',
        'peaceful',
        'caring',
        'tolerant',
        'contemplative',
        'inquisitive',
        'experimental',
        'maximalist',
        'dominant',
        'ambitious',
        'tangible',
        'intangible',
        'relationships',
        'identity',
        'retention',
        'discovery',
        'others',
        'self',
        'safety',
        'confidence',
        'concord',
        'control',
    ];

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Respondent::class);
    }

    public function save(Respondent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Respondent $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findRespondentsOrderedByDifferenceForForm(Submission $submission): Paginator
    {
        $query = $this->createQueryBuilder('r')->addSelect('f')
            ->addSelect($this->buildDifferenceNumber())
            ->innerJoin('r.form', 'f', 'WITH', 'f.type = :formType')
            ->setParameters($this->buildParameterArray($submission))->getQuery()->setFirstResult(0)
            ->setMaxResults(2000);

        return new Paginator($query);
    }

    public function findRespondentsOrderedByDifferenceForUniversity(Submission $submission): Paginator
    {
        $query = $this->createQueryBuilder('r')->addSelect('u')
            ->addSelect($this->buildDifferenceNumber())
            ->innerJoin('r.universityProgram', 'u')
            ->setParameters($this->buildParameterArray($submission, false))->getQuery()->setFirstResult(0)
            ->setMaxResults(2000);

        return new Paginator($query);
    }

    public function findRespondentsOrderedByDifferenceForOccupation(Submission $submission): Paginator
    {
        $query = $this->createQueryBuilder('r')->addSelect('o')
            ->addSelect($this->buildDifferenceNumber())
            ->innerJoin('r.occupation', 'o')
            ->setParameters($this->buildParameterArray($submission, false))->getQuery()->setFirstResult(0)
            ->setMaxResults(2000);

        return new Paginator($query);
    }

    private function buildDifferenceNumber(): string
    {
        $orderBy = [];
        foreach (self::ATTRS as $profileAttribute) {
            $orderBy[] = "ABS(r.$profileAttribute - :$profileAttribute)";
        }

        return '(' . implode(' + ', $orderBy) . ') AS difference';
    }

    private function buildParameterArray(Submission $submission, bool $isForm = true): array
    {
        if ($isForm) {
            $parameters['formType'] = SubmissionTypeEnum::Form6th === $submission->getType() ? FormTypeEnum::SECONDARY
                : FormTypeEnum::HIGHSCHOOL;
        }

        foreach (self::ATTRS as $profileAttribute) {
            $getter = 'get' . ucfirst($profileAttribute);
            $parameters[$profileAttribute] = $submission->{$getter}();
        }

        return $parameters;
    }
}
