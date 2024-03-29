<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class EvaluationDTO
{
    #[Serializer\Type("integer")]
    public int $id;
    #[Serializer\Type("string")]
    public string $description;
    #[Serializer\Type("string")]
    public string $date;
    #[Serializer\Type("float")]
    public float $value;
}