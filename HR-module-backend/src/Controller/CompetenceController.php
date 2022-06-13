<?php

namespace App\Controller;

use App\Dto\AnswearDTO;
use App\Dto\Competence\CompetenceDTO;
use App\Dto\Competence\Request\CompetenceAddRequest;
use App\Dto\Competence\Request\CompetenceRequest;
use App\Dto\Competence\Response\CompetenceAllResponse;
use App\Dto\Competence\Response\CompetenceListResponse;
use App\Dto\Competence\Response\CompetenceRatingResponse;
use App\Dto\Competence\Response\CompetenceResponse;
use App\Dto\Competence\Response\CompetenceSkillsResponse;
use App\Dto\EducationResources\Response\EducationResourcesAllResponse;
use App\Dto\EducationResources\Response\EducationResourcesListResponse;
use App\Dto\EducationResources\Response\EducationResourcesResponse;
use App\Entity\Competence;
use App\Repository\CompetenceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
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
    private CompetenceAllResponse $competenceAllResponse;
    private CompetenceAddRequest $competenceAddRequest;
    private EducationResourcesListResponse $educationResourcesListResponse;
    private $serializer;
    public function __construct(
        CompetenceRequest $competenceRequest,
        CompetenceResponse $competenceResponse,
        CompetenceAddRequest $competenceAddRequest,
        CompetenceListResponse $competenceListResponse,
        CompetenceRatingResponse $competenceRatingResponse,
        CompetenceAllResponse $competenceAllResponse,
        EducationResourcesListResponse $educationResourcesListResponse)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->competenceRequest = $competenceRequest;
        $this->competenceResponse = $competenceResponse;
        $this->competenceAddRequest = $competenceAddRequest;
        $this->competenceRatingResponse = $competenceRatingResponse;
        $this->competenceAllResponse = $competenceAllResponse;
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

    #[Route('/competence/departmentCheck/{id}', name: 'app_competence_departmentckeck', methods: "GET")]
    public function findDepartmentCkeck($id, CompetenceRepository $competenceRepository, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $competence = $user->getWorks()->getMainCompetence();
        $competenceDTO = $this->competenceRatingResponse->transformFromObject($competence);
        return $this->json($competenceDTO, Response::HTTP_OK);
    }

    #[Route('/competence/department/{id}', name: 'app_competence_department', methods: "GET")]
    public function findDepartment($id, CompetenceRepository $competenceRepository, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $competence = $user->getWorks()->getMainCompetence();
        $competenceDTO = $this->competenceRatingResponse->transformFromObject($competence);
        $competenceDTO->rating = $userRepository->checkGradeRating($user, $competence);
        $competenceDTO->comp_name = $userRepository->checkGrade($user, $competence)->getName();
        return $this->json($competenceDTO, Response::HTTP_OK);
    }

    #[Route('/competence/list/{id}', name: 'app_competence_find', methods: "GET")]
    public function findAll($id, CompetenceRepository $competenceRepository, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $competence = $user->getWorks()->getMainCompetence();
        $competenceDTO = $this->competenceListResponse->transformFromObject($competence);
        return $this->json($competenceDTO, Response::HTTP_OK);
    }

    #[Route('/competence/all', name: 'app_competence_findAll', methods: "GET")]
    public function findAllComp(CompetenceRepository $competenceRepository): Response
    {
        $competence = $competenceRepository->findAll();
        $competenceDTO = $this->competenceAllResponse->transformFromObject($competence);
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

    #[Route('/competence/change/{id}', name: 'app_competence_change', methods: "POST")]
    public function change($id, Request $request, CompetenceRepository $competenceRepository, ManagerRegistry  $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $competence = $entityManager->getRepository(Competence::class)->find($id);

        $data = $this->serializer->deserialize($request->getContent(), CompetenceDTO::class, 'json');

        $competence_ = $this->competenceRequest->transformToObject($data);
        $competence->setDescription($competence_->getDescription());
        $competence->setName($competence_->getName());
        $competence->setNeedRating($competence_->getNeedRating());
        $entityManager->flush();
        $answer = new AnswearDTO();
        $answer->status = 'Changed';
        $answer->messageAnswear = "Changed " . $id;
        return $this->json($answer, Response::HTTP_OK);
    }

    #[Route('/competence/add/{id}', name: 'app_competence_add', methods: "POST")]
    public function addCompetence($id, Request $request, CompetenceRepository $competenceRepository, EntityManagerInterface $entityManager): Response
    {
        $competenceLast = $competenceRepository->find($id);
        $data = $this->serializer->deserialize($request->getContent(), CompetenceDTO::class, 'json');
        $competence = $this->competenceAddRequest->transformToObject($data);
        $competence->addCompetence($competenceLast);
        $entityManager->persist($competence);
        $entityManager->flush();
        return $this->json($data, Response::HTTP_CREATED);
    }

    #[Route('/competence/delete/{id}', name: 'app_competence_remove', methods: "POST")]
    public function removeCompetence($id, Request $request, ManagerRegistry  $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $competence = $entityManager->getRepository(Competence::class)->find($id);
        if ($competence) {
            $entityManager->remove($competence);
            $entityManager->flush();
            $answer = new AnswearDTO();
            $answer->status = 'Deleted';
            $answer->messageAnswear = "Deleted " . $id;
            return $this->json($answer, Response::HTTP_OK);

            //return $this->json(Response::HTTP_OK);
        }
        $answer = new AnswearDTO();
        $answer->status = 'Error delete';
        $answer->messageAnswear = "Un  deleted " . $id;
        return $this->json($answer, Response::HTTP_BAD_REQUEST);
    }
}
