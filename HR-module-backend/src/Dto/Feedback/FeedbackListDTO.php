<?php

namespace App\Dto\Feedback;

use JMS\Serializer\Annotation as Serializer;

class FeedbackListDTO
{
    #[Serializer\Type("array<App\Dto\Feedback\FeedbackDTO>")]
    public array $feedbackDTO;
}