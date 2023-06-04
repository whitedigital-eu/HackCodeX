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

    public function findRespondentsOrderedBySimilair(Submission $submission): Paginator
    {
        $formNumbers = SubmissionTypeEnum::Form6th === $submission->getType() ? [7, 8, 9] : [10, 11, 12];
        $qb = $this->createQueryBuilder('r');
        $orderArray = [
            'ABS(r.pragmatic - :pragmatic)',
            'ABS(r.domestic - :domestic)',
//            "ABS(r.traditional - {$submission->getTraditional()})",
//            "ABS(r.peaceful - {$submission->getPeaceful()})",
//            "ABS(r.caring - {$submission->getCaring()})",
//            "ABS(r.tolerant - {$submission->getTolerant()})",
//            "ABS(r.contemplative - {$submission->getContemplative()})",
//            "ABS(r.inquisitive - {$submission->getInquisitive()})",
//            "ABS(r.experimental - {$submission->getExperimental()})",
//            "ABS(r.maximalist - {$submission->getMaximalist()})",
//            "ABS(r.dominant - {$submission->getDominant()})",
//            "ABS(r.ambitious - {$submission->getAmbitious()})",
//            "ABS(r.tangible - {$submission->getTangible()})",
//            "ABS(r.intangible - {$submission->getIntangible()})",
//            "ABS(r.relationships - {$submission->getRelationships()})",
//            "ABS(r.identity - {$submission->getIdentity()})",
//            "ABS(r.retention - {$submission->getRetention()})",
//            "ABS(r.discovery - {$submission->getDiscovery()})",
//            "ABS(r.others - {$submission->getOthers()})",
//            "ABS(r.self - {$submission->getSelf()})",
//            "ABS(r.safety - {$submission->getSafety()})",
//            "ABS(r.confidence - {$submission->getConfidence()})",
//            "ABS(r.concord - {$submission->getConcord()})",
//            "ABS(r.control - {$submission->getControl()})",
        ];
        $query = $qb->addSelect('f')->innerJoin('r.form', 'f', 'WITH', 'f.formNumber IN (:formNumbers)')
            ->setParameters([
                'formNumbers' => $formNumbers,
                'pragmatic' => $submission->getPragmatic(),
                'domestic' => $submission->getDomestic(),
            ])
            ->orderBy(implode(' + ', $orderArray), 'ASC')
            ->getQuery()->setFirstResult(0)
            ->setMaxResults(2000);

        return new Paginator($query);
    }
}
