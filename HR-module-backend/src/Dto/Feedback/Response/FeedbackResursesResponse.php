<?php

namespace App\Dto\Feedback\Response;

use App\Dto\Feedback\FeedbackDTO;
use App\Dto\Feedback\FeedbackListDTO;
use App\Entity\User;
use App\Repository\FeedbackRepository;

class FeedbackResursesResponse
{
    private FeedbackRepository $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->$feedbackRepository = $feedbackRepository;
    }

    /**
     * @param User $object
     */
    public function transformFromObject($object): FeedbackListDTO
    {
        $feedbacks = $this->feedbackRepository->findBy(
            ['educationalResources' => $object->getId()]);
        $dto = new FeedbackListDTO();
        $dto->feedbackDTO = [];
        foreach ($feedbacks as $feedback)
        {
            $feedbackDTO = new FeedbackDTO();
            $feedbackDTO->userId = $feedback->getAuthon()->getId();
            $feedbackDTO->educationalResourcesId = $feedback->getEducationalResources()->getId();
            $feedbackDTO->date = $feedback->getDate();
            $feedbackDTO->note = $feedback->getNote();
            $feedbackDTO->estimation = $feedback->getEstimation();
            array_push($dto->feedbackDTO, $feedbackDTO);
        }
        $dto->feedbackDTO = $feedbacks;
        return $dto;
    }
}