<?php

namespace App\Dto\Feedback\Response;

use App\Dto\Feedback\FeedbackDTO;
use App\Dto\Feedback\FeedbackListDTO;
use App\Entity\EducationalResources;
use App\Repository\FeedbackRepository;

class FeedbackResursesResponse
{
    private FeedbackRepository $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    /**
     * @param EducationalResources $object
     * @return FeedbackListDTO
     */
    public function transformFromObject(EducationalResources $object): FeedbackListDTO
    {
        $dto = new FeedbackListDTO();
        $feedbacks = $this->feedbackRepository->findBy(
            ['educationalResources' => $object->getId()]);
        $dto->feedbackDTO = [];
        foreach ($feedbacks as $feedback)
        {
            $feedbackDTO = new FeedbackDTO();
            $feedbackDTO->userFIO = $feedback->getAuthon()->getFirstName() . ' ' .
                $feedback->getAuthon()->getLastName() . ' ' .
                $feedback->getAuthon()->getPatronymic();
            $feedbackDTO->id = $feedback->getId();
            $feedbackDTO->userId = $feedback->getAuthon()->getId();
            $feedbackDTO->educationalResourcesId = $feedback->getEducationalResources()->getId();
            $feedbackDTO->date = $feedback->getDate();
            $feedbackDTO->note = $feedback->getNote();
            $feedbackDTO->estimation = $feedback->getEstimation();
            array_push($dto->feedbackDTO, $feedbackDTO);
        }
        return $dto;
    }
}