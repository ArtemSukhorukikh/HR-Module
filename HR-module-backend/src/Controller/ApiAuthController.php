<?php

namespace App\Controller;

use App\Dto\Transformer\Request\UserRequestDTOTransformer;
use App\Dto\UserAuthDto;
use App\Dto\UserDto;
use App\Entity\SkillAssessment;
use App\Entity\User;
use App\Repository\CompetenceRepository;
use App\Repository\DepartmentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityOA;
use \Datetime;

#[Route('/api/v1')]
class ApiAuthController extends AbstractController
{
    private $serializer;
    private $validator;
    private $passwordHasher;
    private $userTransformer;

    public function __construct(UserRequestDTOTransformer $userRequestDTOTransformer, ValidatorInterface $validator, UserPasswordHasherInterface $passwordHasher)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->validator = $validator;
        $this->passwordHasher = $passwordHasher;
        $this->userTransformer = $userRequestDTOTransformer;
    }

    /**
     * @OA\Get(
     *     path="api/v1/users/current",
     *     description="Get current user",
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns token user",
     *     @OA\JsonContent(
     *        @OA\Property(
     *          property="token",
     *          type="string",
     *        ),
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="Incorrect login and password pair",
     *     @OA\JsonContent(
     *        @OA\Property(
     *          property="Error message",
     *          type="string"
     *        ),
     *     )
     * )
     * @OA\Response(
     *     response="default",
     *     description="Unxepected error",
     *     @OA\JsonContent(
     *        @OA\Property(
     *          property="code",
     *          type="string"
     *        ),
     *        @OA\Property(
     *          property="message",
     *          type="string"
     *        ),
     *     )
     * )
     */
    #[Route('/auth', name: 'api_login', methods: ['POST'])]
    public function login()
    {
        //auth
    }
    /**
     * @OA\Get(
     *     path="api/v1/users/current",
     *     description="Get current user",
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns token user",
     *     @OA\JsonContent(
     *        @OA\Property(
     *          property="token",
     *          type="string",
     *        ),
     *        @OA\Property(
     *          property="roles",
     *          type="array",
     *          @OA\Items(type="string")
     *        ),
     *     )
     * )
     * @OA\Response(
     *     response=400,
     *     description="",
     *     @OA\JsonContent(
     *        @OA\Property(
     *          property="Error message",
     *          type="string"
     *        ),
     *     )
     * )
     * @OA\Response(
     *     response="default",
     *     description="Unxepected error",
     *     @OA\JsonContent(
     *        @OA\Property(
     *          property="code",
     *          type="string"
     *        ),
     *        @OA\Property(
     *          property="message",
     *          type="string"
     *        ),
     *     )
     * )
     * @SecurityOA(name="Bearer")
     */
    #[Route('/register', name: 'api_register', methods: ['POST'])]
    public function register(
        Request $request,
        UserRepository $userRepository,
        CompetenceRepository $competenceRepository,
        DepartmentRepository $departmentRepository,
        EntityManagerInterface $entityManager,
        JWTTokenManagerInterface $JWTTokenManager
    ): Response
    {
        $userDto = $this->serializer->deserialize($request->getContent(), UserDto::class, 'json');
        $errors = $this->validator->validate($userDto);
        if ($userRepository->findOneBy(['username' => $userDto->username])) {
            $errors->add(new ConstraintViolation(
                message: 'User ' . $userDto->username .  ' already exists.',
                messageTemplate: 'User {{ value }} already exists.',
                parameters: ['value' => $userDto->username],
                root: $userDto,
                propertyPath: 'username',
                invalidValue: $userDto->username
            ));
        }
        if (count($errors) > 0) {
            $jsonErrors = [];
            foreach ($errors as $error) {
                $jsonErrors[$error->getPropertyPath()][] = $error->getMessage();
            }
            return $this->json([
                'errors' => $jsonErrors,
            ], Response::HTTP_BAD_REQUEST);
        }
        $user = new User;
        $user = $this->userTransformer->transformToObject($userDto);
        $user->setPassword($this->passwordHasher->hashPassword($user, $userDto->password));
        $user->setWorks($departmentRepository->findOneBy(["name" => $userDto->department]));
        $entityManager->persist($user);
        $entityManager->flush();
        $competence = $user->getWorks()->getMainCompetence();
        $competence->addUser($user);
        $skills = $competence->getSkills();
        foreach ($skills as $skill){
            $skillsAssessment = new SkillAssessment();
            $skillsAssessment->setUser($user);
            $skillsAssessment->setSkills($skill);
            $skillsAssessment->setEstimation(0);
            $date = new DateTime();
            $skillsAssessment->setDate($date);
            $entityManager->persist($skillsAssessment);
            $entityManager->flush();
        }

        $userAuth = new UserAuthDto();
        $userAuth->roles =  $user->getRoles();
        $userAuth->token = $JWTTokenManager->create($user);
        return $this->json($userAuth, Response::HTTP_CREATED);
    }
}
