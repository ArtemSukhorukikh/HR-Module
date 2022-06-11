<?php

namespace App\Controller;

use App\Dto\Department\Response\DepartmentUsersResponse;
use App\Repository\UserRepository;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/')]
class DepartmentController extends AbstractController
{
    private DepartmentUsersResponse $departmentUsersResponse;
    private $serializer;

    public function __construct(DepartmentUsersResponse $departmentUsersResponse)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->departmentUsersResponse = $departmentUsersResponse;
    }

    #[Route('department/users/{id}', name: 'app_department_users', methods: "GET")]
    public function findDepartmentUsers($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $department = $user->getWorks();
        $departmentUserDTO = $this->departmentUsersResponse->transformFromObject($department);
        return $this->json($departmentUserDTO, Response::HTTP_OK);
    }
}
