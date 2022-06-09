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

    #[Route('/{id}', name: 'app_applicationForTraining_find', methods: "GET")]
    public function findFeedback($id, FeedbackRepository $feedbackRepository): Response
    {
        $feedback = $feedbackRepository->find($id);
        $feedbackDTO = $this->feedbackResponse->transformFromObject($feedback);
        return $this->json($feedbackDTO, Response::HTTP_OK);
    }

    #[Route('/user/{id}', name: 'app_feedback_user_find', methods: "GET")]
    public function findUserFeedback($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $feedbackDTO = $this->feedbackUserResponse->transformFromObject($user);
        return $this->json($feedbackDTO, Response::HTTP_OK);
    }

    #[Route('/resource/{id}', name: 'app_feedback_user_find', methods: "GET")]
    public function findResourcesFeedback($id, EducationalResourcesRepository $educationalResourcesRepository): Response
    {
        $resource = $educationalResourcesRepository->find($id);
        $feedbackDTO = $this->feedbackResursesResponse->transformFromObject($resource);
        return $this->json($feedbackDTO, Response::HTTP_OK);
    }

    #[Route('/new', name: 'app_feedback_new', methods: "POST")]
    public function newFeedback(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), FeedbackDTO::class, 'json');
        $user = $userRepository->find($data->userId);
        if ($user) {
            $feedback = $this->feedbackRequest->transformToObject($data);
            $entityManager->persist($feedback);
            $entityManager->flush();

            return $this->json($data, Response::HTTP_CREATED);
        }

        return $this->json($data, Response::HTTP_BAD_REQUEST);
    }

    #[Route('/delete/{id}', name: 'app_feedback_remove', methods: "POST")]
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
}
