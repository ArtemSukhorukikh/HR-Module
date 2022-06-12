<?php

namespace App\Dto\ApplicationPurchaseOfTraining;

use JMS\Serializer\Annotation as Serializer;

class ApplicationPurchaseOfTrainingStatusDTO
{
    #[Serializer\Type("integer")]
    public int $id;
    #[Serializer\Type("integer")]
    public int $status;
}