<?php

namespace App\Repository;

use App\Entity\ApplicationPurchaseOfTraining;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApplicationPurchaseOfTraining>
 *
 * @method ApplicationPurchaseOfTraining|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApplicationPurchaseOfTraining|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApplicationPurchaseOfTraining[]    findAll()
 * @method ApplicationPurchaseOfTraining[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationPurchaseOfTrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApplicationPurchaseOfTraining::class);
    }

    public function add(ApplicationPurchaseOfTraining $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ApplicationPurchaseOfTraining $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ApplicationPurchaseOfTraining[] Returns an array of ApplicationPurchaseOfTraining objects
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

//    public function findOneBySomeField($value): ?ApplicationPurchaseOfTraining
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
