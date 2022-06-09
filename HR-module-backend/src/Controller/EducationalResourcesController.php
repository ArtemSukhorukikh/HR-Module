<?php

namespace App\Controller;

use App\Dto\EducationResources\Response\EducationResourcesAllResponse;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class EducationalResourcesController extends AbstractController
{
    private EducationResourcesAllResponse $educationResourcesAllResponse;
    private $serializer;
    public function __construct(EducationResourcesAllResponse $educationResourcesAllResponse)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->educationResourcesAllResponse = $educationResourcesAllResponse;
    }

    #[Route('/educationalResources/all', name: 'app_educationalResources', methods: "GET")]
    public function index(): Response
    {
        $educationalResourcesDTO = $this->educationResourcesAllResponse->transformFromObject();
        return $this->json($educationalResourcesDTO, Response::HTTP_OK);
    }
}
