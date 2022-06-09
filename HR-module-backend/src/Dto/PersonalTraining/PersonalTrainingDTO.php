<?php

namespace App\Dto\PersonalTraining;

use JMS\Serializer\Annotation as Serializer;

class PersonalTrainingDTO
{
    #[Serializer\Type("integer")]
    public int $id;
    #[Serializer\Type("integer")]
    public int $appId;
    #[Serializer\Type("string")]
    public string $contractNumber;
    #[Serializer\Type("DateTime<'Y-m-d'>")]
    public \DateTimeInterface $date;

}