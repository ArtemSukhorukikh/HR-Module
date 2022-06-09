<?php

namespace App\Controller;

use App\Dto\AnswearDTO;
use App\Dto\EvaluationDTO;
use App\Dto\Transformer\Request\EvaluationRequestDTOTransformer;
use App\Repository\TaskRepository;
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

    #[Route('/evaluation-add/{id}', name: 'evaluation-add')]
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
}
