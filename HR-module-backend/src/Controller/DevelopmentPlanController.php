<?php

namespace App\Controller;

use App\Dto\DevelopmentPlan\Response\DevelopmentPlanResponse;
use App\Repository\DepartmentRepository;
use App\Repository\UserRepository;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/')]
class DevelopmentPlanController extends AbstractController
{
    private DevelopmentPlanResponse $developmentPlanResponse;
    private $serializer;
    public function __construct(
        DevelopmentPlanResponse $developmentPlanResponse)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->developmentPlanResponse = $developmentPlanResponse;
    }

    #[Route('developmentPlan/{id}', name: 'app_development_plan_user')]
    public function developmentPlanUser($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $department = $user->getWorks();
        $competenceMatrixDTO = $this->developmentPlanResponse->transformFromObject($department);
        return $this->json($competenceMatrixDTO, Response::HTTP_OK);
    }

    #[Route('developmentPlan/department/{id}', name: 'app_development_plan_department')]
    public function developmentPlanDepartment($id, DepartmentRepository $departmentRepository): Response
    {
        $department = $departmentRepository->find($id);
        $competenceMatrixDTO = $this->developmentPlanResponse->transformFromObject($department);
        return $this->json($competenceMatrixDTO, Response::HTTP_OK);
    }
}
