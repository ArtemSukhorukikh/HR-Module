<?php

namespace App\Dto\ApplicationPurchaseOfPersonalTraining;

use JMS\Serializer\Annotation as Serializer;

class ApplicationPurchaseOfPersonalTrainingListDTO
{
    #[Serializer\Type("array<App\Dto\applicationPurchaseOfPersonalTrainingDTO>")]
    public array $applicationPurchaseOfPersonalTrainingDTO;
}