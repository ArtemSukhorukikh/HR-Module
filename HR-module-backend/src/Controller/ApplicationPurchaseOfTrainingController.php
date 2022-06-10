<?php

namespace App\Controller;

use App\Dto\AnswearDTO;
use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingDTO;
use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingStatusDTO;
use App\Dto\ApplicationPurchaseOfTraining\Request\ApplicationPurchaseOfTrainingRequest;
use App\Dto\ApplicationPurchaseOfTraining\Response\ApplicationPurchaseOfTrainingDepartmentResponse;
use App\Dto\ApplicationPurchaseOfTraining\Response\ApplicationPurchaseOfTrainingResponse;
use App\Dto\ApplicationPurchaseOfTraining\Response\ApplicationPurchaseOfTrainingStatusFalseResponse;
use App\Dto\ApplicationPurchaseOfTraining\Response\ApplicationPurchaseOfTrainingUserResponse;
use App\Entity\ApplicationPurchaseOfTraining;
use App\Repository\ApplicationPurchaseOfTrainingRepository;
use App\Repository\DepartmentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/')]
class ApplicationPurchaseOfTrainingController extends AbstractController
{
    private ApplicationPurchaseOfTrainingUserResponse $applicationPurchaseOfTrainingUserResponse;
    private ApplicationPurchaseOfTrainingResponse $applicationPurchaseOfTrainingResponse;
    private ApplicationPurchaseOfTrainingDepartmentResponse $applicationPurchaseOfTrainingDepartmentResponse;
    private ApplicationPurchaseOfTrainingStatusFalseResponse $applicationPurchaseOfTrainingStatusFalseResponse;
    private ApplicationPurchaseOfTrainingRequest $applicationPurchaseOfTrainingRequest;
    private $serializer;

    public function __construct(ApplicationPurchaseOfTrainingUserResponse $applicationPurchaseOfTrainingUserResponse,
                                ApplicationPurchaseOfTrainingResponse $applicationPurchaseOfTrainingResponse,
                                ApplicationPurchaseOfTrainingDepartmentResponse $applicationPurchaseOfTrainingDepartmentResponse,
                                ApplicationPurchaseOfTrainingStatusFalseResponse $applicationPurchaseOfTrainingStatusFalseResponse,
                                ApplicationPurchaseOfTrainingRequest $applicationPurchaseOfTrainingRequest)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->applicationPurchaseOfTrainingUserResponse = $applicationPurchaseOfTrainingUserResponse;
        $this->applicationPurchaseOfTrainingStatusFalseResponse = $applicationPurchaseOfTrainingStatusFalseResponse;
        $this->applicationPurchaseOfTrainingResponse = $applicationPurchaseOfTrainingResponse;
        $this->applicationPurchaseOfTrainingDepartmentResponse = $applicationPurchaseOfTrainingDepartmentResponse;
        $this->applicationPurchaseOfTrainingRequest = $applicationPurchaseOfTrainingRequest;
    }


    #[Route('applicationPOT/{id}', name: 'app_applicationPurchaseOfTraining_find', methods: "GET")]
    public function findApplicationPurchaseOfTraining($id, ApplicationPurchaseOfTrainingRepository $applicationPurchaseOfTrainingRepository): Response
    {
        $application = $applicationPurchaseOfTrainingRepository->find($id);
        $applicationDTO = $this->applicationPurchaseOfTrainingResponse->transformFromObject($application);
        return $this->json($applicationDTO, Response::HTTP_OK);
    }

    #[Route('applicationPOT/user/{id}', name: 'app_applicationPurchaseOfTraining_user', methods: "GET")]
    public function findUserApplicationPurchaseOfTraining($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $applicationDTO = $this->applicationPurchaseOfTrainingUserResponse->transformFromObject($user);
        return $this->json($applicationDTO, Response::HTTP_OK);
    }

    #[Route('applicationPOT/userFalse/{id}', name: 'app_applicationPurchaseOfTraining_userfalse', methods: "GET")]
    public function findUserFalseApplicationPurchaseOfTraining($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $applicationDTO = $this->applicationPurchaseOfTrainingStatusFalseResponse->transformFromObject($user);
        return $this->json($applicationDTO, Response::HTTP_OK);
    }

    #[Route('applicationPOT/department/{id}', name: 'app_applicationPurchaseOfTraining_department', methods: "GET")]
    public function findDepartmentApplicationPurchaseOfTraining($id, DepartmentRepository $departmentRepository): Response
    {
        $department = $departmentRepository->find($id);
        $applicationDTO = $this->applicationPurchaseOfTrainingDepartmentResponse->transformFromObject($department);
        return $this->json($applicationDTO, Response::HTTP_OK);
    }

    #[Route('applicationPOT/new', name: 'app_applicationPurchaseOfTraining_new', methods: "POST")]
    public function newApplicationPurchaseOfTraining(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), ApplicationPurchaseOfTrainingDTO::class, 'json');
        $user = $userRepository->find($data->user_id);
        if ($user) {
            $application = $this->applicationPurchaseOfTrainingRequest->transformToObject($data);
            $entityManager->persist($application);
            $entityManager->flush();

            return $this->json($data, Response::HTTP_CREATED);
        }

        return $this->json($data, Response::HTTP_BAD_REQUEST);
    }

    #[Route('applicationPOT/status', name: 'app_applicationForTraining_status', methods: "POST")]
    public function statusApplicationPurchaseOfTraining(Request $request, ManagerRegistry  $doctrine): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), ApplicationPurchaseOfTrainingStatusDTO::class, 'json');
        $entityManager = $doctrine->getManager();
        $application = $entityManager->getRepository(ApplicationPurchaseOfTraining::class)->find($data->id);
        if ($application) {
            $application->setStatus($data->status);
            $entityManager->flush();

            return $this->json($data, Response::HTTP_CREATED);
        }

        return $this->json($data, Response::HTTP_BAD_REQUEST);
    }

    #[Route('applicationPOT/remove/{id}', name: 'app_applicationForTraining_remove', methods: "GET")]
    public function removeApplicationPurchaseOfTraining($id, Request $request, ManagerRegistry  $doctrine)
    {
        $entityManager = $doctrine->getManager();
        $application = $entityManager->getRepository(ApplicationPurchaseOfTraining::class)->find($id);
        if ($application) {
            $entityManager->remove($application);
            $entityManager->flush();
            $answer = new AnswearDTO();
            $answer->status = 'Deleted';
            $answer->messageAnswear = "Deleted ".$id;
            return $this->json($answer, Response::HTTP_OK);
        }
        $answer = new AnswearDTO();
        $answer->status = 'Error delete';
        $answer->messageAnswear = "Un  deleted ".$id;
        return $this->json($answer, Response::HTTP_BAD_REQUEST);
    }
}
