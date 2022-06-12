<?php

namespace App\Dto\ApplicationPurchaseOfPersonalTraining;

use JMS\Serializer\Annotation as Serializer;

class ApplicationPurchaseOfPersonalTrainingDTO
{
    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("integer")]
    public int $user_id;

    #[Serializer\Type("string")]
    public string $link;

    #[Serializer\Type("string")]
    public string $note;

    #[Serializer\Type("integer")]
    public int $status;
}