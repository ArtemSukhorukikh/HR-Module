<?php

namespace App\Controller;

use App\Dto\ApplicationPurchaseOfPersonalTraining\ApplicationPurchaseOfPersonalTrainingDTO;
use App\Dto\ApplicationPurchaseOfPersonalTraining\ApplicationPurchaseOfPersonalTrainingStatusDTO;
use App\Dto\ApplicationPurchaseOfPersonalTraining\Response\ApplicationPurchaseOfPersonalTrainingDepartmentResponse;
use App\Dto\ApplicationPurchaseOfPersonalTraining\Response\ApplicationPurchaseOfPersonalTrainingResponse;
use App\Dto\ApplicationPurchaseOfPersonalTraining\Response\ApplicationPurchaseOfPersonalTrainingUserResponse;
use App\Dto\ApplicationPurchaseOfPersonalTraining\Request\ApplicationPurchaseOfPersonalTrainingRequest;
use App\Entity\ApplicationPurchaseOfPersonalTraining;
use App\Repository\ApplicationPurchaseOfPersonalTrainingRepository;
use App\Repository\DepartmentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationPurchaseOfPersonalTrainingController extends AbstractController
{
    private ApplicationPurchaseOfPersonalTrainingUserResponse $applicationPurchaseOfPersonalUserResponse;
    private ApplicationPurchaseOfPersonalTrainingResponse $applicationPurchaseOfPersonalResponse;
    private ApplicationPurchaseOfPersonalTrainingDepartmentResponse $applicationPurchaseOfPersonalDepartmentResponse;
    private ApplicationPurchaseOfPersonalTrainingRequest $applicationPurchaseOfPersonalRequest;
    private $serializer;

    public function __construct(ApplicationPurchaseOfPersonalTrainingUserResponse $applicationPurchaseOfPersonalUserResponse,
                                ApplicationPurchaseOfPersonalTrainingResponse $applicationPurchaseOfPersonalResponse,
                                ApplicationPurchaseOfPersonalTrainingDepartmentResponse $applicationPurchaseOfPersonalDepartmentResponse,
                                ApplicationPurchaseOfPersonalTrainingRequest $applicationPurchaseOfPersonalRequest)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->applicationPurchaseOfPersonalUserResponse = $applicationPurchaseOfPersonalUserResponse;
        $this->applicationPurchaseOfPersonalResponse = $applicationPurchaseOfPersonalResponse;
        $this->applicationPurchaseOfPersonalDepartmentResponse = $applicationPurchaseOfPersonalDepartmentResponse;
        $this->applicationPurchaseOfPersonalRequest = $applicationPurchaseOfPersonalRequest;
    }


    #[Route('/{id}', name: 'app_ApplicationPurchaseOfPersonalTraining_find', methods: "GET")]
    public function findApplicationPurchaseOfPersonalTraining($id, ApplicationPurchaseOfPersonalTrainingRepository $ApplicationPurchaseOfPersonalTrainingRepository): Response
    {
        $application = $ApplicationPurchaseOfPersonalTrainingRepository->find($id);
        $applicationDTO = $this->applicationPurchaseOfPersonalResponse->transformFromObject($application);
        return $this->json($applicationDTO, Response::HTTP_OK);
    }

    #[Route('/user/{id}', name: 'app_applicationForTraining_user', methods: "GET")]
    public function findUserApplicationPurchaseOfPersonalTraining($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $applicationDTO = $this->applicationPurchaseOfPersonalUserResponse->transformFromObject($user);
        return $this->json($applicationDTO, Response::HTTP_OK);
    }

    #[Route('/department/{id}', name: 'app_applicationForTraining_user', methods: "GET")]
    public function findDepartmentApplicationPurchaseOfPersonalTraining($id, DepartmentRepository $departmentRepository): Response
    {
        $department = $departmentRepository->find($id);
        $applicationDTO = $this->applicationPurchaseOfPersonalDepartmentResponse->transformFromObject($department);
        return $this->json($applicationDTO, Response::HTTP_OK);
    }

    #[Route('/new', name: 'app_applicationForTraining_new', methods: "POST")]
    public function newApplicationPurchaseOfPersonalTraining(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), ApplicationPurchaseOfPersonalTrainingDTO::class, 'json');
        $user = $userRepository->find($data->userId);
        if ($user) {
            $application = $this->applicationPurchaseOfPersonalRequest->transformToObject($data);
            $entityManager->persist($application);
            $entityManager->flush();

            return $this->json($data, Response::HTTP_CREATED);
        }

        return $this->json($data, Response::HTTP_BAD_REQUEST);
    }

    #[Route('/status', name: 'app_applicationForTraining_status', methods: "POST")]
    public function statusApplicationPurchaseOfPersonalTraining(Request $request, ManagerRegistry  $doctrine): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), ApplicationPurchaseOfPersonalTrainingStatusDTO::class, 'json');
        $entityManager = $doctrine->getManager();
        $application = $entityManager->getRepository(ApplicationPurchaseOfPersonalTraining::class)->find($data->id);
        if ($application) {
            $application->setStatus($data->status);
            $entityManager->flush();

            return $this->json($data, Response::HTTP_CREATED);
        }

        return $this->json($data, Response::HTTP_BAD_REQUEST);
    }

    #[Route('/remove/{id}', name: 'app_applicationForTraining_remove', methods: "POST")]
    public function removeApplicationPurchaseOfPersonalTraining($id, Request $request, ManagerRegistry  $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $application = $entityManager->getRepository(ApplicationPurchaseOfPersonalTraining::class)->find($id);
        if ($application) {
            $entityManager->remove($application);
            $entityManager->flush();

            //return $this->json($data, Response::HTTP_CREATED);
        }

       //return $this->json($data, Response::HTTP_BAD_REQUEST);
    }
}
