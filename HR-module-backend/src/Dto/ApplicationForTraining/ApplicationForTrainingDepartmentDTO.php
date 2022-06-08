<?php

namespace App\Dto\ApplicationForTraining;

use JMS\Serializer\Annotation as Serializer;


class ApplicationForTrainingDepartmentDTO
{
    #[Serializer\Type("array<App\Dto\ApplicationForTrainingListDTO>")]
    public array $applicationForTrainingListDTO;
}