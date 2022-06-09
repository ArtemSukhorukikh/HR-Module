<?php

namespace App\Dto\ApplicationPurchaseOfPersonalTraining;

use JMS\Serializer\Annotation as Serializer;

class ApplicationPurchaseOfPersonalTrainingStatusDTO
{
    #[Serializer\Type("integer")]
    public int $id;
    #[Serializer\Type("integer")]
    public int $status;
}