<?php

namespace App\Controller;

use App\Dto\Transformer\Request\UserRequestDTOTransformer;
use App\Dto\Transformer\Response\UserResponseDTOTransformer;
use App\Dto\UserAuthDto;
use App\Dto\UserCurrentDto;
use App\Dto\UserDto;
use App\Dto\UsersDto;
use App\Entity\SkillAssessment;
use App\Entity\User;
use App\Repository\CompetenceRepository;
use App\Repository\DepartmentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Redmine\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Security as SecurityOA;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/v1/users')]
class ApiUserController extends AbstractController
{
    private Security $security;
    private $serializer;
    public UserResponseDTOTransformer $userResponseDTOTransformer;
    public UserRequestDTOTransformer $userTransformer;
    public $validator;

    public function __construct(Security $security,
                                UserResponseDTOTransformer $userResponseDTOTransformer,
    UserRequestDTOTransformer $requestDTOTransformer,
                                ValidatorInterface $validator)
    {
        $this->security = $security;
        $this->userResponseDTOTransformer = $userResponseDTOTransformer;
        $this->serializer = SerializerBuilder::create()->build();
        $this->userTransformer = $requestDTOTransformer;
        $this->validator = $validator;
    }
    /**
     * @OA\Get(
     *     path="api/v1/users/current",
     *     description="Get current user",
     * )
     * @OA\Response(
     *     response=200,
     *     description="Returns information about current user",
     *     @OA\JsonContent(
     *        @OA\Property(
     *          property="username",
     *          type="string",
     *        ),
     *        @OA\Property(
     *          property="roles",
     *          type="array",
     *          @OA\Items(type="string")
     *        ),
     *        @OA\Property(
     *          property="balance",
     *          type="float",
     *        )
     *     )
     * )
     * @OA\Response(
     *     response=401,
     *     description="User is not authenticated",
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
    #[Route('/current', name: 'current_user', methods: ['GET'])]
    public function getCurrentUser(UserRepository $userRepository): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
           return $this->json([
           'status_code' => Response::HTTP_UNAUTHORIZED,
           'message' => 'User is not authenticated.'
           ], Response::HTTP_UNAUTHORIZED);
        }
        $currentUser = $this->userResponseDTOTransformer->transformFromObject($user);
        return $this->json($currentUser, Response::HTTP_OK);
    }

    #[Route('/search', name: 'user_search', methods: ['POST'])]
    public function getUserSearch(Request $request, UserRepository $userRepository): Response
    {
        $username = $request->toArray()["username"];

        $user = $userRepository->findOneBy(['username' => $username]);
        try {
            $currentUser = $this->userResponseDTOTransformer->transformFromObject($user);
            return $this->json($currentUser, Response::HTTP_OK);
        }catch (Exception $exception){

        }
        if (!$user) {
            $this->json([
                'status_code' => Response::HTTP_BAD_REQUEST,
                'message' => 'User is not find.'
            ], Response::HTTP_BAD_REQUEST);
        }


    }

    #[Route('/update/{id}', name: 'user_update', methods: ['POST'])]
    public function updateUser(int $id,Request $request,
                               UserRepository $userRepository,
                               CompetenceRepository $competenceRepository,
                               DepartmentRepository $departmentRepository,
                               EntityManagerInterface $entityManager,): Response
    {
        $userDto = $this->serializer->deserialize($request->getContent(), UserDto::class, 'json');

        $userNew = $this->userTransformer->transformToObject($userDto);
        $user =  $userRepository->find($id);
        if ($user) {
            $errors = []; //$this->validator->validate($userDto);
            if ($user->getUsername() != $userNew->getUsername()){
                if ($userRepository->findOneBy(['username' => $userDto->username])) {
                    $errors[] = new ConstraintViolation(
                        message: 'User ' . $userDto->username .  ' already exists.',
                        messageTemplate: 'User {{ value }} already exists.',
                        parameters: ['value' => $userDto->username],
                        root: $userDto,
                        propertyPath: 'username',
                        invalidValue: $userDto->username
                    );
                }
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
            $user->setFirstName($userNew->getFirstName());
            $user->setLastName($userNew->getLastName());
            $user->setPatronymic($userNew->getPatronymic());
            $user->setPosition($userNew->getPosition());
            $user->setDateOfHiring($userNew->getDateOfHiring());
            $user->setUsername($userNew->getUsername());
            $user->setWorks($departmentRepository->findOneBy(["name" => $userDto->department]));
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->json(['ok'], Response::HTTP_ACCEPTED);
        }
        else {
            return $this->json(['error'], Response::HTTP_BAD_REQUEST);
        }



    }


    #[Route('/all', name: 'user_all', methods: ['GET'])]
    public function getUsers(UserRepository $userRepository){
        $usersDTO = new UsersDto();
        $usersDTO->users = $this->userResponseDTOTransformer->transformFromObjects($userRepository->findAll());
        return $this->json($usersDTO, Response::HTTP_OK);
    }

}
