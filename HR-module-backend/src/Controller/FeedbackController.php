<?php

namespace App\Controller;

use App\Dto\Feedback\FeedbackDTO;
use App\Dto\Feedback\Request\FeedbackAddRequest;
use App\Dto\Feedback\Request\FeedbackRequest;
use App\Dto\Feedback\Request\FeedbackUpdateRequest;
use App\Dto\Feedback\Response\FeedbackResponse;
use App\Dto\Feedback\Response\FeedbackResursesResponse;
use App\Dto\Feedback\Response\FeedbackUserResponse;
use App\Entity\Feedback;
use App\Repository\EducationalResourcesRepository;
use App\Repository\FeedbackRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class FeedbackController extends AbstractController
{
    private FeedbackResponse $feedbackResponse;
    private FeedbackUserResponse $feedbackUserResponse;
    private FeedbackResursesResponse $feedbackResursesResponse;
    private FeedbackAddRequest $feedbackAddRequest;
    private FeedbackRequest $feedbackRequest;
    private FeedbackUpdateRequest $feedbackUpdateRequest;
    private $serializer;

    public function __construct(FeedbackResponse $feedbackResponse,
                                FeedbackUserResponse $feedbackUserResponse,
                                FeedbackResursesResponse $feedbackResursesResponse,
                                FeedbackAddRequest $feedbackAddRequest,
                                FeedbackRequest $feedbackRequest,
                                FeedbackUpdateRequest $feedbackUpdateRequest)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->feedbackResponse = $feedbackResponse;
        $this->feedbackUserResponse = $feedbackUserResponse;
        $this->feedbackResursesResponse = $feedbackResursesResponse;
        $this->feedbackAddRequest = $feedbackAddRequest;
        $this->feedbackRequest = $feedbackRequest;
        $this->feedbackUpdateRequest = $feedbackUpdateRequest;
    }

    #[Route('/feedback/resource/{id}', name: 'app_feedback_resource_find', methods: "GET")]
    public function findResourcesFeedback($id, EducationalResourcesRepository $educationalResourcesRepository): Response
    {
        $resource = $educationalResourcesRepository->find($id);
        $feedbackDTO = $this->feedbackResursesResponse->transformFromObject($resource);
        return $this->json($feedbackDTO, Response::HTTP_OK);
    }

    #[Route('/feedback/{id}', name: 'app_applicationForTraining_find', methods: "GET")]
    public function findFeedback($id, FeedbackRepository $feedbackRepository): Response
    {
        $feedback = $feedbackRepository->find($id);
        $feedbackDTO = $this->feedbackResponse->transformFromObject($feedback);
        return $this->json($feedbackDTO, Response::HTTP_OK);
    }

    #[Route('/feedback/user/{id}/{ide}', name: 'app_feedback_user_find', methods: "GET")]
    public function findUserFeedback($id, $ide, UserRepository $userRepository): Response
    {
        $feedbackDTO = $this->feedbackUserResponse->transformFromObject($id, $ide);
        return $this->json($feedbackDTO, Response::HTTP_OK);
    }

    #[Route('/feedback/delete/{id}', name: 'app_feedback_remove', methods: "POST")]
    public function removeFeedback($id, Request $request, ManagerRegistry  $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $feedback = $entityManager->getRepository(Feedback::class)->find($id);
        if ($feedback) {
            $entityManager->remove($feedback);
            $entityManager->flush();

            //return $this->json(Response::HTTP_OK);
        }

        //return $this->json($data, Response::HTTP_BAD_REQUEST);
    }

    #[Route('/feedback/new', name: 'app_feedback_new', methods: "POST")]
    public function newFeedback(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), FeedbackDTO::class, 'json');
        $user = $userRepository->find($data->user_id);
        if ($user) {
            $feedback = $this->feedbackRequest->transformToObject($data);
            $entityManager->persist($feedback);
            $entityManager->flush();

            return $this->json($data, Response::HTTP_CREATED);
        }

        return $this->json($data, Response::HTTP_BAD_REQUEST);
    }
}
