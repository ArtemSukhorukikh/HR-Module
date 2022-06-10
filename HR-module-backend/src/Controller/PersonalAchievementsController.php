<?php

namespace App\Controller;

use App\Dto\AnswearDTO;
use App\Dto\PersonalAchievementsAddUserDTO;
use App\Dto\PersonalAchievementsDTO;
use App\Dto\Transformer\Request\PersonalAchievementsRequestDTOTransformer;
use App\Dto\Transformer\Response\PersonalAchivmentsResponseDTOTransformer;
use App\Dto\UserDto;
use App\Repository\PersonalAchievementsRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/api/v1/achievements')]
class PersonalAchievementsController extends AbstractController
{
    private $serializer;
    private Security $security;
    private PersonalAchievementsRequestDTOTransformer $achievementsRequestDTOTransformer;
    private PersonalAchivmentsResponseDTOTransformer $achivmentsResponseDTOTransformer;

    public function __construct(Security $security,
                                PersonalAchivmentsResponseDTOTransformer $achivmentsResponseDTOTransformer,
                                PersonalAchievementsRequestDTOTransformer $achievementsRequestDTOTransformer)
    {
        $this->security = $security;
        $this->serializer = SerializerBuilder::create()->build();
        $this->achievementsRequestDTOTransformer = $achievementsRequestDTOTransformer;
        $this->achivmentsResponseDTOTransformer = $achivmentsResponseDTOTransformer;
    }

    #[Route('/user', name: 'app_personal_achievements_user', methods: "GET")]
    public function getPersonalAchievementsUser(UserRepository $userRepository, Request $request): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), UserDto::class, 'json');
        $user = $userRepository->findOneBy(['username' => $data->username]);
        if ($user) {
            return $this->json($this->achivmentsResponseDTOTransformer->transformFromObjects($user->getPersonalAchievements()), Response::HTTP_OK);
        }
        return $this->json([
            'status_code' => Response::HTTP_BAD_REQUEST,
            'message' => 'User is not find.'
        ], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/', name: 'app_personal_achievements', methods: "GET")]
    public function getPersonalAchievements(UserRepository $userRepository, Request $request): Response
    {
        $user = $this->security->getUser();
        if (!$user) {
            $this->json([
                'status_code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'User is not authenticated.'
            ], Response::HTTP_UNAUTHORIZED);
        }
        if ($user) {
            return $this->json($this->achivmentsResponseDTOTransformer->transformFromObjects($user->getPersonalAchievements()), Response::HTTP_OK);
        }
        return $this->json([
            'status_code' => Response::HTTP_BAD_REQUEST,
            'message' => 'Bad Data.'
        ], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/new', name: 'app_personal_achievements_new', methods: "POST")]
    public function newPersonalAchievements(EntityManagerInterface $entityManager, Request $request): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), PersonalAchievementsDTO::class, 'json');
        if ($data) {
            $achivment = $this->achievementsRequestDTOTransformer->transformToObject($data);
            $entityManager->persist($achivment);
            $entityManager->flush();
            return $this->json($data, Response::HTTP_CREATED);
        }
        return $this->json([
            'status_code' => Response::HTTP_BAD_REQUEST,
            'message' => 'Bad Data.'
        ], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/update/{id}', name: 'app_personal_achievements_update', methods: "POST")]
    public function updatePersonalAchievements(int $id,PersonalAchievementsRepository $repository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $achivment = $repository->find($id);
        $data = $this->serializer->deserialize($request->getContent(), PersonalAchievementsDTO::class, 'json');
        if ($data && $achivment) {
            $achivment->setDescription($data->description);
            $achivment->setValue($data->value);
            $achivment->setName($data->name);
            $entityManager->persist($achivment);
            $entityManager->flush();
            return $this->json($data, Response::HTTP_CREATED);
        }
        return $this->json([
            'status_code' => Response::HTTP_BAD_REQUEST,
            'message' => 'Bad Data.'
        ], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/delete/{id}', name: 'app_personal_achievements_update', methods: "POST")]
    public function deletePersonalAchievements(int $id,PersonalAchievementsRepository $repository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $achivment = $repository->find($id);
        $data = $this->serializer->deserialize($request->getContent(), PersonalAchievementsDTO::class, 'json');
        if ($data && $achivment) {
            $entityManager->remove($achivment);
            $entityManager->flush();
            $answer = new AnswearDTO();
            $answer->status = "deleted";
            $answer->messageAnswear = "Delete personal achivment";
            return $this->json($answer, Response::HTTP_CREATED);
        }
        return $this->json([
            'status_code' => Response::HTTP_BAD_REQUEST,
            'message' => 'Bad Data.'
        ], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/add', name: 'app_personal_achievements_add', methods: "POST")]
    public function addPersonalAchievements(EntityManagerInterface $entityManager, Request $request, UserRepository $userRepository, PersonalAchievementsRepository $achievementsRepository): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), PersonalAchievementsAddUserDTO::class, 'json');
        if ($data) {
            $achievement = $achievementsRepository->findOneBy(["id" => $data->id]);
            $user = $userRepository->findOneBy(["username" => $data->username]);
            if ($user && $achievement) {
                $achievement->addUserAchivment($user);
                $entityManager->persist($achievement);
                $entityManager->flush();
                return $this->json($data, Response::HTTP_CREATED);
            }
        }
        return $this->json([
            'status_code' => Response::HTTP_BAD_REQUEST,
            'message' => 'Bad Data.'
        ], Response::HTTP_BAD_REQUEST);
    }
}
