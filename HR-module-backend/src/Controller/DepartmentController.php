<?php

namespace App\Controller;

use App\Dto\Department\DepartmentDTO;
use App\Dto\Department\Request\DepartmentRequest;
use App\Dto\Department\Response\DepartmentListResponse;
use App\Dto\Department\Response\DepartmentResponse;
use App\Dto\Department\Response\DepartmentUsersResponse;
use App\Entity\Competence;
use App\Entity\Department;
use App\Repository\CompetenceRepository;
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
class DepartmentController extends AbstractController
{
    private DepartmentUsersResponse $departmentUsersResponse;
    private DepartmentListResponse $departmentListResponse;
    private DepartmentResponse $departmentResponse;
    private DepartmentRequest $departmentRequest;
    private $serializer;

    public function __construct(DepartmentUsersResponse $departmentUsersResponse,
                                DepartmentListResponse $departmentListResponse,
                                DepartmentResponse $departmentResponse,
                                DepartmentRequest $departmentRequest)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->departmentListResponse = $departmentListResponse;
        $this->departmentResponse = $departmentResponse;
        $this->departmentUsersResponse = $departmentUsersResponse;
        $this->departmentRequest = $departmentRequest;
    }

    #[Route('department/findAll', name: 'app_department_findAll', methods: "GET")]
    public function findAll(DepartmentRepository $departmentRepository): Response
    {
        $departments = $departmentRepository->findAll();
        $departmentUserDTO = $this->departmentResponse->transformFromObjects($departments);
        return $this->json( $departmentUserDTO,Response::HTTP_OK);
    }

    #[Route('department/{id}', name: 'app_department_find', methods: "GET")]
    public function findDepartment($id, DepartmentRepository $departmentRepository): Response
    {
        $department = $departmentRepository->find($id);
        $departmentUserDTO = $this->departmentResponse->transformFromObject($department);
        return $this->json($departmentUserDTO, Response::HTTP_OK);
    }

    #[Route('department', name: 'test', methods: "GET")]
    public function test(DepartmentRepository $departmentRepository): Response
    {
        $departments = $departmentRepository->find(1);
        $departmentUserDTO = $this->departmentListResponse->transformFromObject($departments);
        return $this->json( $departmentUserDTO,Response::HTTP_OK);
    }

    #[Route('department/users/{id}', name: 'app_department_users', methods: "GET")]
    public function findDepartmentUsers($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $department = $user->getWorks();
        $departmentUserDTO = $this->departmentUsersResponse->transformFromObject($department);
        return $this->json($departmentUserDTO, Response::HTTP_OK);
    }

    #[Route('department/new', name: 'app_department_new', methods: "POST")]
    public function newDepartment( Request $request, CompetenceRepository $competenceRepository, EntityManagerInterface $entityManager): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), DepartmentDTO::class, 'json');
        $department = $this->departmentRequest->transformToObject($data);
        $competence = new Competence();
        $competence->setName($data->main_competence_name);
        $competence->setType(1);
        $competence->setNeedRating(0);
        $competence->setDescription("Старовая компетенция отдела ".$department->getName());
        $entityManager->persist($competence);
        $entityManager->flush();
        $department->setMainCompetence($competence);
        $entityManager->persist($department);
        $entityManager->flush();
        return $this->json($data, Response::HTTP_CREATED);
    }

    #[Route('department/update/{id}', name: 'app_competence_add', methods: "POST")]
    public function addCompetence($id, Request $request, CompetenceRepository $competenceRepository, ManagerRegistry  $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $department = $entityManager->getRepository(Department::class)->find($id);

        $entityManager->flush();
        return $this->json( Response::HTTP_CREATED);
    }
}
