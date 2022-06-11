<?php

namespace App\Repository;

use App\Entity\Competence;
use App\Entity\SkillAssessment;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function add(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(User $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);

        $this->add($user, true);
    }

    public function checkGradeRating(User $user, Competence $competence)
    {
        $skillAssessments = $user->getSkillAssessments();
        $skills = $competence->getSkills();
        $trueSkillAssessments = [];
        foreach($skills as $skill)
        {
            foreach($skillAssessments as $skillAssessment)
            {
                if ($skillAssessment->getSkills()->getId() == $skill->getId())
                {
                    $trueSkillAssessments[] = $skillAssessment;
                }
            }
        }
        $sum = 0;
        $count = 0;
        foreach ($trueSkillAssessments as $trueSkillAssessment)
        {
            $count += 1;
            $sum += $trueSkillAssessment->getEstimation();
        }
        $rating = $sum / $count;
        return $rating;
    }

    public function checkGrade(User $user, Competence $competence)
    {
        $rating = $this->checkGradeRating($user, $competence);
        $grade = 0;
        $comp = $competence->getIncludes()[0];
        while ($comp != null)
        {
            if($comp->getNeedRating() > $rating)
            {
                return $grade;
            }
            $grade = $comp->getId();
            $comp = $comp->getIncludes()[0];
        }
        return $grade;
    }


//    /**
//     * @return User[] Returns an array of User objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('u.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
