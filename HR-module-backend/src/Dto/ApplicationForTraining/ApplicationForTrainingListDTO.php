<?php

namespace App\Dto\ApplicationForTraining;

use JMS\Serializer\Annotation as Serializer;

class ApplicationForTrainingListDTO
{
    #[Serializer\Type("array<App\Dto\ApplicationForTrainingDTO>")]
    public array $applicationForTrainingDTO;
}