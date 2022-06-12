<?php

namespace App\Dto\ApplicationPurchaseOfTraining;

use JMS\Serializer\Annotation as Serializer;

class ApplicationPurchaseOfTrainingListDTO
{
    #[Serializer\Type("array<App\Dto\ApplicationPurchaseOfTrainingDTO>")]
    public array $applicationPurchaseOfTrainingDTO;
}