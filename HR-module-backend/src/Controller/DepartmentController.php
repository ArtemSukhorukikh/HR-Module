<?php

namespace App\Controller;

use App\Dto\Department\DepartmentDTO;
use App\Dto\Department\Request\DepartmentRequest;
use App\Dto\Department\Response\DepartmentUsersResponse;
use App\Entity\Competence;
use App\Repository\CompetenceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/')]
class DepartmentController extends AbstractController
{
    private DepartmentUsersResponse $departmentUsersResponse;
    private DepartmentRequest $departmentRequest;
    private $serializer;

    public function __construct(DepartmentUsersResponse $departmentUsersResponse,
                                DepartmentRequest $departmentRequest)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->departmentUsersResponse = $departmentUsersResponse;
        $this->departmentRequest = $departmentRequest;
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
}
