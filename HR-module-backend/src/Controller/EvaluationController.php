<?php

namespace App\Controller;

use App\Dto\AnswearDTO;
use App\Dto\EvaluationDTO;
use App\Dto\Transformer\Request\EvaluationRequestDTOTransformer;
use App\Repository\TaskEvaluationRepository;
use App\Repository\TaskRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/api/v1')]
class EvaluationController extends AbstractController
{
    private $serializer;
    private Security $security;
    private EvaluationRequestDTOTransformer $requestDTOTransformer;

    public function __construct(Security $security, EvaluationRequestDTOTransformer $requestDTOTransformer)
    {
        $this->security = $security;
        $this->serializer = SerializerBuilder::create()->build();
        $this->requestDTOTransformer = $requestDTOTransformer;
    }

    #[Route('/evaluation/add/{id}', name: 'evaluation-add')]
    public function index(int $id,
                          TaskRepository $taskRepository,
                          EntityManagerInterface $entityManager,
                          Request $request): Response
    {
        $task = $taskRepository->find($id);
        if ($task) {
            $evaluationFromDTO = $this->serializer->deserialize($request->getContent(), EvaluationDTO::class, 'json');
            $evaluation = $this->requestDTOTransformer->transformToObject($evaluationFromDTO);
            $evaluation->setToTask($task);
            $entityManager->persist($evaluation);
            $entityManager->flush();
            $answer = new AnswearDTO();
            $answer->status = "Created";
            $answer->messageAnswear = "Create new evaluation to task ". $id;
            return $this->json($answer, Response::HTTP_CREATED);
        } else {
            $answer = new AnswearDTO();
            $answer->status = "Error";
            $answer->messageAnswear = "Task ". $id . "does not find";
            return $this->json($answer, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/evaluation/update/{id}', name: 'evaluation-update')]
    public function update(int $id,
                          TaskEvaluationRepository $repository,
                          EntityManagerInterface $entityManager,
                          Request $request): Response
    {
        $evaluation = $repository->find($id);
        if ($evaluation) {
            $evaluationFromDTO = $this->serializer->deserialize($request->getContent(), EvaluationDTO::class, 'json');
            $evaluation->setDate(new DateTime($evaluationFromDTO->date));
            $evaluation->setValue($evaluationFromDTO->value);
            $evaluation->setDescription($evaluationFromDTO->description);
            $entityManager->persist($evaluation);
            $entityManager->flush();
            $answer = new AnswearDTO();
            $answer->status = "Update";
            $answer->messageAnswear = "Update evaluation ". $id;
            return $this->json($answer, Response::HTTP_CREATED);
        } else {
            $answer = new AnswearDTO();
            $answer->status = "Error";
            $answer->messageAnswear = "Task ". $id . "does not find";
            return $this->json($answer, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/evaluation/delete/{id}', name: 'evaluation-delete')]
    public function delete(int $id,
                           TaskEvaluationRepository $repository,
                           EntityManagerInterface $entityManager,
                           Request $request): Response
    {
        $evaluation = $repository->find($id);
        if ($evaluation) {
            $entityManager->remove($evaluation);
            $entityManager->flush();
            $answer = new AnswearDTO();
            $answer->status = "Deleted";
            $answer->messageAnswear = "Delete evaluation ". $id;
            return $this->json($answer, Response::HTTP_CREATED);
        } else {
            $answer = new AnswearDTO();
            $answer->status = "Error";
            $answer->messageAnswear = "Task ". $id . "does not find";
            return $this->json($answer, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/evaluation/{id}', name: 'evaluation-show')]
    public function show(int $id,
                           TaskRepository $repository,
                           EntityManagerInterface $entityManager,
                           Request $request): Response
    {
        $task = $repository->find($id);
        if ($task) {
            $mark = $task->getTaskEvaluation();
            if ($mark) {
                $dto = new EvaluationDTO();
                $dto->id = $mark->getId();
                $dto->date = $mark->getDate()->format("YYYY-MM-dd");
                $dto->value = $mark->getValue();
                $dto->description = $mark->getDescription();
                return $this->json($dto, Response::HTTP_OK);
            }
            else {
                return $this->json([], Response::HTTP_NO_CONTENT);
            }
        } else {
            $answer = new AnswearDTO();
            $answer->status = "Error";
            $answer->messageAnswear = "Task ". $id . "does not find";
            return $this->json($answer, Response::HTTP_BAD_REQUEST);
        }
    }
}
