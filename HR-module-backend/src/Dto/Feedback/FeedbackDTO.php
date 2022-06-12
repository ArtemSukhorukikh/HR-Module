<?php

namespace App\Dto\Feedback;

use JMS\Serializer\Annotation as Serializer;

class FeedbackDTO
{
    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("string")]
    public string $userFIO;

    #[Serializer\Type("integer")]
    public int $user_id = 3;

    #[Serializer\Type("integer")]
    public int $educational_resources_id = 3;

    #[Serializer\Type("integer")]
    public int $estimation = 5;

    #[Serializer\Type("string")]
    public string $note = 'qwe';

    #[Serializer\Type("DateTime<'Y-m-d'>")]
    public \DateTimeInterface $date;
}