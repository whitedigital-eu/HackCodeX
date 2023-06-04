<?php declare(strict_types = 1);

namespace App\Repository;

use App\Entity\Respondent;
use App\Entity\Submission;
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

    public function findRespondentsOrderedBySimilar(Submission $submission): Paginator
    {
        $profileAttributes = [
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
        $query = $this->createQueryBuilder('r')->addSelect('f')
            ->innerJoin('r.form', 'f', 'WITH', 'f.formNumber IN (:formNumbers)')
            ->setParameters($this->buildParameterArray($submission, $profileAttributes))
            ->orderBy($this->buildCriteriaOrderBy($profileAttributes), 'ASC')->getQuery()->setFirstResult(0)
            ->setMaxResults(2000);
        return new Paginator($query);
    }

    private function buildCriteriaOrderBy(array $profileAttributes): string
    {
        $orderBy = [];
        foreach ($profileAttributes as $profileAttribute) {
            $orderBy[] = "ABS(r.$profileAttribute - :$profileAttribute)";
        }
        return implode(' + ', $orderBy);
    }

    private function buildParameterArray(Submission $submission, array $profileAttributes): array
    {
        $parameters['formNumbers'] = SubmissionTypeEnum::Form6th === $submission->getType() ? [7, 8, 9] : [10, 11, 12];
        foreach ($profileAttributes as $profileAttribute) {
            $getter = 'get' . ucfirst($profileAttribute);
            $parameters[$profileAttribute] = $submission->$getter();
        }
        return $parameters;
    }
}