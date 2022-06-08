<?php

namespace App\Dto\ApplicationForTraining;

use JMS\Serializer\Annotation as Serializer;

class ApplicationForTrainingDTO
{
    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("integer")]
    public int $userId;

    #[Serializer\Type("integer")]
    public int $edResId;

    #[Serializer\Type("DateTime<'Y-m-d'>")]
    public \DateTimeInterface $startDate;

    #[Serializer\Type("DateTime<'Y-m-d'>")]
    public \DateTimeInterface $endDate;

    #[Serializer\Type("integer")]
    public int $mathodOfPassage;

    #[Serializer\Type("string")]
    public string $note;

    #[Serializer\Type("integer")]
    public int $status;
}