<?php

namespace App\Dto\ApplicationForTraining;

use JMS\Serializer\Annotation as Serializer;

class ApplicationForTrainingDTO
{
    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("integer")]
    public int $user_id;

    #[Serializer\Type("string")]
    public string $user_name;

    #[Serializer\Type("string")]
    public string $user_username;

    #[Serializer\Type("integer")]
    public int $ed_res_id;

    #[Serializer\Type("string")]
    public string $ed_name;

    #[Serializer\Type("DateTime<'Y-m-d'>")]
    public \DateTimeInterface $start_date;

    #[Serializer\Type("DateTime<'Y-m-d'>")]
    public \DateTimeInterface $end_date;

    #[Serializer\Type("integer")]
    public int $method_of_passage;

    #[Serializer\Type("string")]
    public string $note;

    #[Serializer\Type("integer")]
    public int $status;
}