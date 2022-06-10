<?php

namespace App\Controller;

use App\Dto\EducationResources\Response\EducationResourcesAllResponse;
use App\Dto\EducationResources\Response\EducationResourcesListResponse;
use App\Dto\EducationResources\Response\EducationResourcesResponse;
use App\Repository\CompetenceRepository;
use App\Repository\EducationalResourcesRepository;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class EducationalResourcesController extends AbstractController
{
    private EducationResourcesAllResponse $educationResourcesAllResponse;
    private EducationResourcesResponse $educationResourcesResponse;
    private EducationResourcesListResponse $educationResourcesListResponse;
    private $serializer;
    public function __construct(
        EducationResourcesAllResponse $educationResourcesAllResponse,
        EducationResourcesResponse $educationResourcesResponse,
        EducationResourcesListResponse $educationResourcesListResponse)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->educationResourcesAllResponse = $educationResourcesAllResponse;
        $this->educationResourcesResponse = $educationResourcesResponse;
        $this->educationResourcesListResponse = $educationResourcesListResponse;
    }

    #[Route('/educationalResources/findCompetence/{id}', name: 'app_educationalResources_findCompetence', methods: "GET")]
    public function findCompetence($id, CompetenceRepository $competenceRepository): Response
    {
        $competence = $competenceRepository->find($id);
        $educationalResourcesDTO = $this->educationResourcesListResponse->transformFromObject($competence);
        return $this->json($educationalResourcesDTO, Response::HTTP_OK);
    }

    #[Route('/educationalResources/all', name: 'app_educationalResources_all', methods: "GET")]
    public function findAll(CompetenceRepository $competenceRepository): Response
    {
        $criteria = array_filter(array(
            'competences' => null
        ));
        $competence = $competenceRepository->findBy($criteria);
        $educationalResourcesDTO = $this->educationResourcesAllResponse->transformFromObject($competence);
        return $this->json($educationalResourcesDTO, Response::HTTP_OK);
    }

    #[Route('/educationalResources/{id}', name: 'app_educationalResources_find', methods: "GET")]
    public function find($id, EducationalResourcesRepository $educationalResourcesRepository): Response
    {
        $educationalResources = $educationalResourcesRepository->find($id);
        $educationalResourcesDTO = $this->educationResourcesResponse->transformFromObject($educationalResources);
        return $this->json($educationalResourcesDTO, Response::HTTP_OK);
    }
}
