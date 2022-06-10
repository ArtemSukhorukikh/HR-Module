<?php

namespace App\Controller;

use App\Dto\Competence\CompetenceDTO;
use App\Dto\Competence\Request\CompetenceRequest;
use App\Dto\Competence\Response\CompetenceListResponse;
use App\Dto\Competence\Response\CompetenceResponse;
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
    private EducationResourcesListResponse $educationResourcesListResponse;
    private $serializer;
    public function __construct(
        CompetenceRequest $competenceRequest,
        CompetenceResponse $competenceResponse,
        CompetenceListResponse $competenceListResponse,
        EducationResourcesListResponse $educationResourcesListResponse)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->competenceRequest = $competenceRequest;
        $this->competenceResponse = $competenceResponse;
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

    #[Route('/competence/list/{id}', name: 'app_competence_find', methods: "GET")]
    public function findAll($id, CompetenceRepository $competenceRepository): Response
    {
        $competence = $competenceRepository->find($id);
        $competenceDTO = $this->competenceListResponse->transformFromObject($competence);
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
