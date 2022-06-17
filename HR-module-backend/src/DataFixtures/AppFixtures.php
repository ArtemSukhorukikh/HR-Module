<?php

namespace App\DataFixtures;

use App\Dto\Transformer\Request\UserRequestDTOTransformer;
use App\Entity\Competence;
use App\Entity\Department;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use JMS\Serializer\SerializerBuilder;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserRequestDTOTransformer $userRequestDTOTransformer, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $grade = new Competence();
        $grade->setName("Стартовый грейд HR-отдел");
        $grade->setDescription("Стартовый грейд HR-отдела");
        $grade->setNeedRating(0);
        $grade->setType(1);
        $manager->persist($grade);

        $department = new Department();
        $department->setName("HR-отдел");
        $department->setMainCompetence($grade);
        $manager->persist($department);

        $user = new User();
        $date = new DateTime();
        $user->setDateOfHiring($date);
        $user->setUsername("HR manager");
        $user->setFirstName("HR manage");
        $user->setLastName("HR manage");
        $user->setPatronymic("HR manage");
        $user->setWorks($department);
        $user->setPosition("Работник HR-отдела");
        $user->setRoles(array('ROLE_HR'));
        $user->addCompetence($user->getWorks()->getMainCompetence());
        $user->setPassword($this->passwordHasher->hashPassword($user, "123qwe"));

        $manager->persist($user);

        $manager->flush();
    }
}
