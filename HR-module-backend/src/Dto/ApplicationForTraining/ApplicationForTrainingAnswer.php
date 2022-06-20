<?php

namespace App\Dto\ApplicationForTraining;

use JMS\Serializer\Annotation as Serializer;

class ApplicationForTrainingAnswer
{
    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("string")]
    public string $login;

    #[Serializer\Type("string")]
    public string $password;
}