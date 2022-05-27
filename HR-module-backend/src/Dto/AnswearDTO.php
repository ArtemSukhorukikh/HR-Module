<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class AnswearDTO
{
    #[Serializer\Type("string")]
    public string $status;

    #[Serializer\Type("string")]
    public string $messageAnswear;
}