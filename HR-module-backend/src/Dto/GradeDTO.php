<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class GradeDTO
{
    #[Serializer\Type("string")]
    public string $name;
}