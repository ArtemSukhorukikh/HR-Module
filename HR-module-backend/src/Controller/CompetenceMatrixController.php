<?php

namespace App\Controller;

use App\Dto\CompetenceMatrix\Response\CompetenceMatrixResponse;
use App\Repository\DepartmentRepository;
use App\Repository\UserRepository;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/')]
class CompetenceMatrixController extends AbstractController
{
    private CompetenceMatrixResponse $competenceMatrixResponse;
    private $serializer;
    public function __construct(
        CompetenceMatrixResponse $competenceMatrixResponse)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->competenceMatrixResponse = $competenceMatrixResponse;
    }

    #[Route('competenceMatrix/department/{id}', name: 'app_competence_matrix_department')]
    public function competenceDepartmentMatrix($id, DepartmentRepository $departmentRepository): Response
    {
        $department = $departmentRepository->find($id);
        $competenceMatrixDTO = $this->competenceMatrixResponse->transformFromObject($department);
        return $this->json($competenceMatrixDTO, Response::HTTP_OK);
    }

    #[Route('competenceMatrix/{id}', name: 'app_competence_matrix')]
    public function competenceMatrix($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $department = $user->getWorks();
        $competenceMatrixDTO = $this->competenceMatrixResponse->transformFromObject($department);
        return $this->json($competenceMatrixDTO, Response::HTTP_OK);
    }
}
