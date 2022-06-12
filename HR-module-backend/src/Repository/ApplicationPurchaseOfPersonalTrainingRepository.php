<?php

namespace App\Repository;

use App\Entity\ApplicationPurchaseOfPersonalTraining;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ApplicationPurchaseOfPersonalTraining>
 *
 * @method ApplicationPurchaseOfPersonalTraining|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApplicationPurchaseOfPersonalTraining|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApplicationPurchaseOfPersonalTraining[]    findAll()
 * @method ApplicationPurchaseOfPersonalTraining[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApplicationPurchaseOfPersonalTrainingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApplicationPurchaseOfPersonalTraining::class);
    }

    public function add(ApplicationPurchaseOfPersonalTraining $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ApplicationPurchaseOfPersonalTraining $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ApplicationPurchaseOfPersonalTraining[] Returns an array of ApplicationPurchaseOfPersonalTraining objects
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

//    public function findOneBySomeField($value): ?ApplicationPurchaseOfPersonalTraining
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
