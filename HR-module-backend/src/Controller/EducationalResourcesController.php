<?php

namespace App\Controller;

use App\Dto\AnswearDTO;
use App\Dto\EducationResources\EducationResourcesAllDTO;
use App\Dto\EducationResources\EducationResourcesDTO;
use App\Dto\EducationResources\Request\EducationResourcesRequest;
use App\Dto\EducationResources\Response\EducationResourcesAllResponse;
use App\Dto\EducationResources\Response\EducationResourcesListResponse;
use App\Dto\EducationResources\Response\EducationResourcesResponse;
use App\Dto\EducationResources\Response\EducationResourcesUseResponse;
use App\Entity\Competence;
use App\Entity\EducationalResources;
use App\Repository\CompetenceRepository;
use App\Repository\EducationalResourcesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class EducationalResourcesController extends AbstractController
{
    private EducationResourcesAllResponse $educationResourcesAllResponse;
    private EducationResourcesRequest $educationResourcesRequest;
    private EducationResourcesResponse $educationResourcesResponse;
    private EducationResourcesListResponse $educationResourcesListResponse;
    private EducationResourcesUseResponse $educationResourcesUseResponse;
    private $serializer;
    public function __construct(
        EducationResourcesAllResponse $educationResourcesAllResponse,
        EducationResourcesResponse $educationResourcesResponse,
        EducationResourcesUseResponse $educationResourcesUseResponse,
        EducationResourcesRequest $educationResourcesRequest,
        EducationResourcesListResponse $educationResourcesListResponse)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->educationResourcesRequest = $educationResourcesRequest;
        $this->educationResourcesAllResponse = $educationResourcesAllResponse;
        $this->educationResourcesUseResponse = $educationResourcesUseResponse;
        $this->educationResourcesResponse = $educationResourcesResponse;
        $this->educationResourcesListResponse = $educationResourcesListResponse;
    }



    #[Route('/educationalResources/{id}', name: 'app_educationalResources_find', methods: "GET")]
    public function findResource($id, EducationalResourcesRepository $educationalResourcesRepository): Response
    {
        $educationalResources = $educationalResourcesRepository->find($id);
        $educationalResourcesDTO = $this->educationResourcesResponse->transformFromObject($educationalResources);
        return $this->json($educationalResourcesDTO, Response::HTTP_OK);
    }

    #[Route('/educationalResources/findCompetence/{id}', name: 'app_educationalResources_findCompetence', methods: "GET")]
    public function findCompetence($id, CompetenceRepository $competenceRepository): Response
    {
        $competence = $competenceRepository->find($id);
        $educationalResourcesDTO = $this->educationResourcesListResponse->transformFromObject($competence);
        return $this->json($educationalResourcesDTO, Response::HTTP_OK);
    }

    #[Route('/educationalResources/findAll', name: 'app_educationalResources_find_all', methods: "GET")]
    public function findUseAll(CompetenceRepository $competenceRepository, EducationalResourcesRepository $educationalResourcesRepository): Response
    {
        $data = $educationalResourcesRepository->findAll();
        $objects = [];
        foreach($data as $object){
            if ($object->getType() != 1){
                $objects[] = $object;
            }
        }
        $educationalResourcesDTO = $this->educationResourcesUseResponse->transformFromObject($objects);
        return $this->json($educationalResourcesDTO, Response::HTTP_OK);
    }

    #[Route('/educationalResources/all', name: 'app_educationalResources_all', methods: "GET")]
    public function findAll(CompetenceRepository $competenceRepository): Response
    {
        $competence = $competenceRepository->findBy(['type' => 1]);
        //$educationalResourcesDTO = new EducationResourcesAllDTO();
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

    #[Route('/educationalResources/new/{id}', name: 'app_educationalResources_new', methods: "POST")]
    public function newEducationalResources($id, Request $request, CompetenceRepository $competenceRepository,EntityManagerInterface $entityManager): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), EducationResourcesDTO::class, 'json');
        $educationalResource = $this->educationResourcesRequest->transformToObject($data);
        $educationalResource->addCompetence($competenceRepository->find($id));
        $entityManager->persist($educationalResource);
        $entityManager->flush();
        return $this->json($data, Response::HTTP_CREATED);
    }

    #[Route('/educationalResources/add/{idc}/{ide}', name: 'app_educationalResources_add', methods: "POST")]
    public function addEducationalResources($idc, $ide, Request $request, CompetenceRepository $competenceRepository,EducationalResourcesRepository $educationalResourcesRepository, ManagerRegistry  $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $competence = $entityManager->getRepository(Competence::class)->find($idc);
        $resource = $entityManager->getRepository(EducationalResources::class)->find($ide);
        $resource->addCompetence($competence);
        $entityManager->flush();
        $answer = new AnswearDTO();
        $answer->status = 'Changed';
        $answer->messageAnswear = "Changed " . $idc . " " . $ide;
        return $this->json($answer, Response::HTTP_OK);
    }

    #[Route('/educationalResources/delete/{idc}/{ide}', name: 'app_educationalResources_deleteComp', methods: "POST")]
    public function deleteCompEducationalResources($idc, $ide, Request $request, CompetenceRepository $competenceRepository,EducationalResourcesRepository $educationalResourcesRepository, ManagerRegistry  $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $competence = $entityManager->getRepository(Competence::class)->find($idc);
        $resource = $entityManager->getRepository(EducationalResources::class)->find($ide);
        $resource->removeCompetence($competence);
        $entityManager->flush();
        $answer = new AnswearDTO();
        $answer->status = 'Changed';
        $answer->messageAnswear = "Changed " . $idc . " " . $ide;
        return $this->json($answer, Response::HTTP_OK);
    }

    #[Route('/educationalResources/change/{id}', name: 'app_educationalResources_change', methods: "POST")]
    public function changeEducationalResources($id, Request $request, CompetenceRepository $competenceRepository, ManagerRegistry  $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $edRes = $entityManager->getRepository(EducationalResources::class)->find($id);

        $data = $this->serializer->deserialize($request->getContent(), EducationResourcesDTO::class, 'json');

        $edRes_ = $this->educationResourcesRequest->transformToObject($data);
        $edRes->setName($edRes_->getName());
        $edRes->setDescription($edRes_->getDescription());
        $edRes->setPrice($edRes_->getPrice());
        $edRes->setType($edRes_->getType());
        $edRes->setLink($edRes_->getLink());
        $entityManager->flush();
        $answer = new AnswearDTO();
        $answer->status = 'Changed';
        $answer->messageAnswear = "Changed " . $id;
        return $this->json($answer, Response::HTTP_OK);
    }

    #[Route('/educationalResources/delete/{id}', name: 'app_educationalResources_remove', methods: "POST")]
    public function removeEducationalResources($id, Request $request, ManagerRegistry  $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $edRes = $entityManager->getRepository(EducationalResources::class)->find($id);
        if ($edRes) {
            $entityManager->remove($edRes);
            $entityManager->flush();
            $answer = new AnswearDTO();
            $answer->status = 'Deleted';
            $answer->messageAnswear = "Deleted " . $id;
            return $this->json($answer, Response::HTTP_OK);
        }
        $answer = new AnswearDTO();
        $answer->status = 'Error delete';
        $answer->messageAnswear = "Un  deleted " . $id;
        return $this->json($answer, Response::HTTP_BAD_REQUEST);
    }
}
