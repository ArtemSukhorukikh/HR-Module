<?php

namespace App\Repository;

use App\Entity\SkillAssessment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SkillAssessment>
 *
 * @method SkillAssessment|null find($id, $lockMode = null, $lockVersion = null)
 * @method SkillAssessment|null findOneBy(array $criteria, array $orderBy = null)
 * @method SkillAssessment[]    findAll()
 * @method SkillAssessment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SkillAssessmentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SkillAssessment::class);
    }

    public function add(SkillAssessment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(SkillAssessment $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return SkillAssessment[] Returns an array of SkillAssessment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?SkillAssessment
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
