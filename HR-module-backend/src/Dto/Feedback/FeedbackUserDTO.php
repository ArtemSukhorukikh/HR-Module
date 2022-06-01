<?php

namespace App\Dto\Feedback;

use JMS\Serializer\Annotation as Serializer;

class FeedbackUserDTO
{
    #[Serializer\Type("integer")]
    public int $userId;

    #[Serializer\Type("integer")]
    public int $educationalResourcesId;

    #[Serializer\Type("App\Dto\FeedbackDTO")]
    public FeedbackDTO $feedbackDTO;

    public function __construct(FeedbackDTO $feedbackDTO)
    {
        $this->feedbackDTO = $feedbackDTO;
    }
}