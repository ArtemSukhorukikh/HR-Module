<?php

namespace App\Dto\ApplicationForTraining;

use JMS\Serializer\Annotation as Serializer;

class ApplicationForTrainingDeleteDTO
{
    #[Serializer\Type("integer")]
    public int $id;
}