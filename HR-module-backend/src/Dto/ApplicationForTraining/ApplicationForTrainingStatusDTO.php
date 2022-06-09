<?php

namespace App\Dto\ApplicationForTraining;

use JMS\Serializer\Annotation as Serializer;

class ApplicationForTrainingStatusDTO
{
    #[Serializer\Type("integer")]
    public int $id;
    #[Serializer\Type("integer")]
    public int $status;
}