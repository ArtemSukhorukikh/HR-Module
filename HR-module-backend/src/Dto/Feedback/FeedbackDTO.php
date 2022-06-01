<?php

namespace App\Dto\Feedback;

use JMS\Serializer\Annotation as Serializer;

class FeedbackDTO
{
    #[Serializer\Type("integer")]
    public int $estimation;

    #[Serializer\Type("string")]
    public string $note;

    #[Serializer\Type("DateTime<'Y-m-d'>")]
    public \DateTimeInterface $date;
}