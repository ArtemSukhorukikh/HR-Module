<?php

namespace App\Controller;

use App\Dto\PersonalTraining\PersonalTrainingDTO;
use App\Dto\PersonalTraining\Request\PersonalTrainingRequest;
use App\Dto\PersonalTraining\Response\PersonalTrainingResponse;
use App\Entity\ApplicationPurchaseOfPersonalTraining;
use App\Entity\PersonalTraining;
use App\Repository\ApplicationPurchaseOfPersonalTrainingRepository;
use App\Repository\PersonalTrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PersonalTrainingController extends AbstractController
{
    private PersonalTrainingResponse $personalTrainingResponse;
    private PersonalTrainingRequest $personalTrainingRequest;
    private $serializer;

    public function __construct(PersonalTrainingResponse $personalTrainingResponse,
                                PersonalTrainingRequest $personalTrainingRequest)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->personalTrainingResponse = $personalTrainingResponse;
        $this->personalTrainingRequest = $personalTrainingRequest;
    }

    #[Route('/{id}', name: 'app_personalTraining_find', methods: "GET")]
    public function findFeedback($id, PersonalTrainingRepository $personalTrainingRepository): Response
    {
        $training = $personalTrainingRepository->find($id);
        $trainingDTO = $this->personalTrainingResponse->transformFromObject($training);
        return $this->json($trainingDTO, Response::HTTP_OK);
    }

    #[Route('/new', name: 'app_feedback_new', methods: "POST")]
    public function newFeedback(Request $request, EntityManagerInterface $entityManager, ApplicationPurchaseOfPersonalTrainingRepository $personalTrainingRepository): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), PersonalTrainingDTO::class, 'json');
        $app = $personalTrainingRepository->find($data->id);
        if ($app) {
            $feedback = $this->personalTrainingRequest->transformToObject($data);
            $entityManager->persist($feedback);
            $entityManager->flush();

            return $this->json($data, Response::HTTP_CREATED);
        }

        return $this->json($data, Response::HTTP_BAD_REQUEST);
    }
}
