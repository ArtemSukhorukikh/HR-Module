<?php

namespace App\Dto\Feedback\Response;

use App\Dto\Feedback\FeedbackDTO;
use App\Dto\Feedback\FeedbackListDTO;
use App\Entity\EducationalResources;
use App\Entity\User;
use App\Repository\FeedbackRepository;

class FeedbackUserResponse
{
    private FeedbackRepository $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    /**
     * @param string $object
     * @param string $object0
     */
    public function transformFromObject($object, $object0): ?FeedbackDTO
    {
        $feedback = $this->feedbackRepository->findOneBy(
            ['authon' => $object0, 'educationalResources' => $object]);
        if ($feedback == null){
            return null;
        }
        $dto = new FeedbackDTO();
        $dto->user_id = $feedback->getAuthon()->getId();
        $dto->educational_resources_id = $feedback->getEducationalResources()->getId();
        $dto->date = $feedback->getDate();
        $dto->note = $feedback->getNote();
        $dto->estimation = $feedback->getEstimation();
        return $dto;
    }
}