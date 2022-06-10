<?php

namespace App\Dto\Feedback\Response;

use App\Dto\Feedback\FeedbackDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\Feedback;

class FeedbackResponse extends AbstractResponceDTOTransformer
{
    /**
     * @param Feedback $feedback
     */
    public function transformFromObject($feedback): FeedbackDTO
    {
        $dto = new FeedbackDTO();
        $dto->userFIO = $feedback->getAuthon()->getFirstName() . ' ' .
            $feedback->getAuthon()->getLastName() . ' ' .
            $feedback->getAuthon()->getPatronymic();
        $dto->user_id = $feedback->getAuthon()->getId();
        $dto->educational_resources_id = $feedback->getEducationalResources()->getId();
        $dto->estimation = $feedback->getEstimation();
        $dto->date = $feedback->getDate();
        $dto->note = $feedback->getNote();
        return $dto;
    }
}