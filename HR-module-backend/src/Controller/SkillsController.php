<?php

namespace App\Controller;

use App\Dto\Skills\Response\SkillsDepartmentResponse;
use App\Dto\Skills\Response\SkillsResponse;
use App\Repository\DepartmentRepository;
use App\Repository\UserRepository;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/')]
class SkillsController extends AbstractController
{
    private SkillsDepartmentResponse $skillsDepartmentResponse;
    private SkillsResponse $skillsResponse;
    private $serializer;

    public function __construct(SkillsDepartmentResponse $skillsDepartmentResponse,
                                SkillsResponse $skillsResponse)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->skillsDepartmentResponse = $skillsDepartmentResponse;
        $this->skillsResponse = $skillsResponse;
    }
    #[Route('skills/department/{id}', name: 'app_skills_department', methods: "GET")]
    public function findSkillsDepartment($id, DepartmentRepository $departmentRepository, UserRepository $userRepository): Response
    {
        $department = $userRepository->find($id)->getWorks();
        $skillsDTO = $this->skillsDepartmentResponse->transformFromObject($department);
        return $this->json($skillsDTO, Response::HTTP_OK);
    }
}
