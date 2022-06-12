<?php

namespace App\Dto\ApplicationPurchaseOfTraining;

use JMS\Serializer\Annotation as Serializer;


class ApplicationPurchaseOfTrainingDepartmentDTO
{
    #[Serializer\Type("array<App\Dto\ApplicationPurchaseOfTrainingListDTO>")]
    public array $applicationPurchaseOfTrainingListDTO;
}