<?php

namespace App\Controller;

use App\Dto\Competence\CompetenceDTO;
use App\Dto\Competence\Request\CompetenceRequest;
use App\Dto\Competence\Response\CompetenceListResponse;
use App\Dto\Competence\Response\CompetenceRatingResponse;
use App\Dto\Competence\Response\CompetenceResponse;
use App\Dto\Competence\Response\CompetenceSkillsResponse;
use App\Dto\EducationResources\Response\EducationResourcesAllResponse;
use App\Dto\EducationResources\Response\EducationResourcesListResponse;
use App\Dto\EducationResources\Response\EducationResourcesResponse;
use App\Repository\CompetenceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class CompetenceController extends AbstractController
{
    private CompetenceRequest $competenceRequest;
    private CompetenceResponse $competenceResponse;
    private CompetenceListResponse $competenceListResponse;
    private CompetenceRatingResponse $competenceRatingResponse;
    private EducationResourcesListResponse $educationResourcesListResponse;
    private $serializer;
    public function __construct(
        CompetenceRequest $competenceRequest,
        CompetenceResponse $competenceResponse,
        CompetenceListResponse $competenceListResponse,
        CompetenceRatingResponse $competenceRatingResponse,
        EducationResourcesListResponse $educationResourcesListResponse)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->competenceRequest = $competenceRequest;
        $this->competenceResponse = $competenceResponse;
        $this->competenceRatingResponse = $competenceRatingResponse;
        $this->competenceListResponse = $competenceListResponse;
        $this->educationResourcesListResponse = $educationResourcesListResponse;
    }

    #[Route('/competence/{id}', name: 'app_competence_find', methods: "GET")]
    public function find($id, CompetenceRepository $competenceRepository): Response
    {
        $competence = $competenceRepository->find($id);
        $competenceDTO = $this->competenceResponse->transformFromObject($competence);
        return $this->json($competenceDTO, Response::HTTP_OK);
    }

    #[Route('/competence/department/{id}', name: 'app_competence_department', methods: "GET")]
    public function findDepartment($id, CompetenceRepository $competenceRepository, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $competence = $user->getWorks()->getMainCompetence();
        $competenceDTO = $this->competenceRatingResponse->transformFromObject($competence);
        $competenceDTO->rating = $userRepository->checkGradeRating($user, $competence);
        return $this->json($competenceDTO, Response::HTTP_OK);
    }

    #[Route('/competence/list/{id}', name: 'app_competence_find', methods: "GET")]
    public function findAll($id, CompetenceRepository $competenceRepository, UserRepository $userRepository): Response
    {
        $competence = $competenceRepository->find($id);
        //var_dump($userRepository->checkGrade($userRepository->find(1), $competence));
        $competenceDTO = $this->competenceListResponse->transformFromObject($competence);
        //$competenceDTO = $this->competenceSkillsResponse->transformFromObject($competence);
        return $this->json($competenceDTO, Response::HTTP_OK);
    }

    #[Route('/competence/new', name: 'app_competence_new', methods: "POST")]
    public function new(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), CompetenceDTO::class, 'json');
        $competence = $this->competenceRequest->transformToObject($data);
        $entityManager->persist($competence);
        $entityManager->flush();
        return $this->json($data, Response::HTTP_CREATED);
    }
}
