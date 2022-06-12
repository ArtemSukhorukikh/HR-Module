<?php

namespace App\Dto\ApplicationPurchaseOfTraining;

use JMS\Serializer\Annotation as Serializer;


class ApplicationPurchaseOfPersonalTrainingDepartmentDTO
{
    #[Serializer\Type("array<App\Dto\ApplicationPurchaseOfPersonalTrainingListDTO>")]
    public array $applicationPurchaseOfPersonalTrainingListDTO;
}