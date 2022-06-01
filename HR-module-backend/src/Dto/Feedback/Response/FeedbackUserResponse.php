<?php

namespace App\Dto\Feedback\Response;


use App\Dto\Feedback\FeedbackUserDTO;
use App\Entity\Feedback;
use App\Entity\User;
use App\Entity\EducationalResources;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;

class FeedbackUserResponse  extends AbstractResponceDTOTransformer
{
    /**
     * @param Feedback $feedback
     */
    public function transformFromObject($feedback): FeedbackUserDTO
    {

    }
}