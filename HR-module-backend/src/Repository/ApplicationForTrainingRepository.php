<?php

namespace App\Repository;

use App\Entity\ApplicationForTraining;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApplicationForTraining>
 *
 * @method ApplicationForTraining|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApplicationForTraining|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApplicationForTraining[]    findAll()
 * @method ApplicationForTraining[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationForTrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApplicationForTraining::class);
    }

    public function add(ApplicationForTraining $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ApplicationForTraining $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ApplicationForTraining[] Returns an array of ApplicationForTraining objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ApplicationForTraining
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
