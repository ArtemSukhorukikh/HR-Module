<?php

namespace App\Controller;

use App\Dto\AnswearDTO;
use App\Dto\GradeDTO;
use App\Dto\GradeToAddUserDTO;
use App\Dto\Transformer\Request\GradeRequestDTOTransformer;
use App\Dto\Transformer\Response\GradesUserResponseDTOTransformer;
use App\Dto\UserDto;
use App\Entity\Grade;
use App\Entity\User;
use App\Repository\GradeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/api/v1/grades')]
class GradeController extends AbstractController
{
    private GradesUserResponseDTOTransformer $gradesUserResponseDTOTransformer;
    private GradeRequestDTOTransformer $gradeRequestDTOTransformer;
    private $serializer;
    private Security $security;

    public function __construct(GradesUserResponseDTOTransformer $gradesUserResponseDTOTransformer,
                                GradeRequestDTOTransformer $gradeRequestDTOTransformer,
                                Security $security)
    {
        $this->security = $security;
        $this->serializer = SerializerBuilder::create()->build();
        $this->gradeRequestDTOTransformer = $gradeRequestDTOTransformer;
        $this->gradesUserResponseDTOTransformer = $gradesUserResponseDTOTransformer;
    }

    #[Route('/', name: 'app_grade_user', methods: "GET")]
    public function userGrades(): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
            $this->json([
                'status_code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'User is not authenticated.'
            ], Response::HTTP_UNAUTHORIZED);
        }
        if ($user) {
            $dto = $this->gradesUserResponseDTOTransformer->transformFromObject($user->getGrades());
            return $this->json($dto, Response::HTTP_OK);
        }
    }

    #[Route('/user-grade', name: 'app_user-grades', methods: "GET")]
    public function usernameGrades(Request $request, UserRepository $userRepository): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), UserDto::class, "json");
        $user = $userRepository->findOneBy(["username" => $data->username]);
        if ($user) {
            $dto = $this->gradesUserResponseDTOTransformer->transformFromObject($user->getGrades());
            return $this->json($dto, Response::HTTP_OK);
        }
    }

    #[Route('/add-grade', name: 'app_add_user_grade', methods: "POST")]
    public function addGrade(Request $request,
                             UserRepository $userRepository,
                             GradeRepository $gradeRepository,
                             EntityManagerInterface $entityManager): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), GradeToAddUserDTO::class, 'json');
        $user = $userRepository->findOneBy(['username' => $data->username]);
        $grade = $gradeRepository->find($data->id);
        if ($user && $grade) {
            $user->addGrade($grade);
            $entityManager->persist($user);
            $entityManager->flush();
            $dto = new AnswearDTO();
            $dto->messageAnswear='Added';
            $dto->status = "Added";
            return $this->json($dto, Response::HTTP_OK);
        }
    }

    #[Route('/new', name: 'app_grade_new', methods: "POST")]
    public function newGrade(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), GradeDTO::class, 'json');
        if ($data) {
            $grade = $this->gradeRequestDTOTransformer->transformToObject($data);
            $entityManager->persist($grade);
            $entityManager->flush();
            return $this->json($data, Response::HTTP_CREATED);
        }
    }
}
