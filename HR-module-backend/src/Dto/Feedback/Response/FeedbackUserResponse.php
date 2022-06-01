<?php

namespace App\Dto\Feedback\Response;


use App\Dto\Feedback\FeedbackDTO;
use App\Dto\Feedback\FeedbackUserDTO;
use App\Entity\Feedback;
use App\Entity\User;
use App\Entity\EducationalResources;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;

class FeedbackUserResponse  extends AbstractResponceDTOTransformer
{
    /**
     * @param Feedback $object
     */
    public function transformFromObject($object): FeedbackUserDTO
    {
        $feedback = new FeedbackDTO();
        $feedback->estimation = $object->getEstimation();
        $feedback->date = $object->getDate();
        $feedback->note = $object->getNote();
        $dto = new FeedbackUserDTO($feedback);
        $dto->userId = $object->getAuthon()->getId();
        $dto->educationalResourcesId = $object->getEducationalResources()->getId();
    }
}