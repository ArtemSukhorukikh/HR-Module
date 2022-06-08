<?php

namespace App\Dto\Feedback;

use JMS\Serializer\Annotation as Serializer;

class FeedbackDeleteDTO
{
    #[Serializer\Type("integer")]
    public int $id;
}