<?php

namespace App\Controller;

use App\Dto\AnswearDTO;
use App\Dto\ApplicationForTraining\ApplicationForTrainingDeleteDTO;
use App\Dto\ApplicationForTraining\ApplicationForTrainingDTO;
use App\Dto\ApplicationForTraining\ApplicationForTrainingListDTO;
use App\Dto\ApplicationForTraining\ApplicationForTrainingStatusDTO;
use App\Dto\ApplicationForTraining\Request\ApplicationForTrainingRequest;
use App\Dto\ApplicationForTraining\Response\ApplicationForTrainingDepartmentResponse;
use App\Dto\ApplicationForTraining\Response\ApplicationForTrainingResponse;
use App\Dto\ApplicationForTraining\Response\ApplicationForTrainingUserResponse;
use App\Entity\ApplicationForTraining;
use App\Entity\Department;
use App\Repository\ApplicationForTrainingRepository;
use App\Repository\DepartmentRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/v1')]
class ApplicationForTrainingController extends AbstractController
{
    private ApplicationForTrainingUserResponse $applicationForTrainingUserResponse;
    private ApplicationForTrainingResponse $applicationForTrainingResponse;
    private ApplicationForTrainingDepartmentResponse $applicationForTrainingDepartmentResponse;
    private ApplicationForTrainingRequest $applicationForTrainingRequest;
    private $serializer;

    public function __construct(ApplicationForTrainingUserResponse $applicationForTrainingUserResponse,
                                ApplicationForTrainingResponse $applicationForTrainingResponse,
                                ApplicationForTrainingDepartmentResponse $applicationForTrainingDepartmentResponse,
                                ApplicationForTrainingRequest $applicationForTrainingRequest)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->applicationForTrainingUserResponse = $applicationForTrainingUserResponse;
        $this->applicationForTrainingResponse = $applicationForTrainingResponse;
        $this->applicationForTrainingDepartmentResponse = $applicationForTrainingDepartmentResponse;
        $this->applicationForTrainingRequest = $applicationForTrainingRequest;
    }


    #[Route('/{id}', name: 'app_applicationForTraining_find', methods: "GET")]
    public function findApplicationForTraining($id, ApplicationForTrainingRepository $applicationForTrainingRepository): Response
    {
        $application = $applicationForTrainingRepository->find($id);
        $applicationDTO = $this->applicationForTrainingResponse->transformFromObject($application);
        return $this->json($applicationDTO, Response::HTTP_OK);
    }

    #[Route('/user/{id}', name: 'app_applicationForTraining_user', methods: "GET")]
    public function findUserApplicationForTraining($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $applicationDTO = $this->applicationForTrainingUserResponse->transformFromObject($user);
        return $this->json($applicationDTO, Response::HTTP_OK);
    }

    #[Route('/department/{id}', name: 'app_applicationForTraining_user', methods: "GET")]
    public function findDepartmentApplicationForTraining($id, DepartmentRepository $departmentRepository): Response
    {
        $department = $departmentRepository->find($id);
        $applicationDTO = $this->applicationForTrainingDepartmentResponse->transformFromObject($department);
        return $this->json($applicationDTO, Response::HTTP_OK);
    }

    #[Route('/new', name: 'app_applicationForTraining_new', methods: "POST")]
    public function newApplicationForTraining(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), ApplicationForTrainingDTO::class, 'json');
        $user = $userRepository->find($data->userId);
        if ($user) {
            $application = $this->applicationForTrainingRequest->transformToObject($data);
            $entityManager->persist($application);
            $entityManager->flush();

            return $this->json($data, Response::HTTP_CREATED);
        }

        return $this->json($data, Response::HTTP_BAD_REQUEST);
    }

    #[Route('/status', name: 'app_applicationForTraining_status', methods: "POST")]
    public function statusApplicationForTraining(Request $request, ManagerRegistry  $doctrine): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), ApplicationForTrainingStatusDTO::class, 'json');
        $entityManager = $doctrine->getManager();
        $application = $entityManager->getRepository(ApplicationForTraining::class)->find($data->id);
        if ($application) {
            $application->setStatus($data->status);
            $entityManager->flush();

            return $this->json($data, Response::HTTP_CREATED);
        }

        return $this->json($data, Response::HTTP_BAD_REQUEST);
    }

    #[Route('/delete/{id}', name: 'app_applicationForTraining_remove', methods: "POST")]
    public function removeApplicationForTraining($id, Request $request, ManagerRegistry  $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $application = $entityManager->getRepository(ApplicationForTraining::class)->find($id);
        if ($application) {
            $entityManager->remove($application);
            $entityManager->flush();
            $answer = new AnswearDTO();
            $answer->status = 'Remove';
            $answer->messageAnswear = "Remove";
            return $this->json($answer, Response::HTTP_OK);
        }
        $answer = new AnswearDTO();
        $answer->status = 'Remove error';
        $answer->messageAnswear = "Remove error";
        return $this->json($answer, Response::HTTP_BAD_REQUEST);
    }
}
