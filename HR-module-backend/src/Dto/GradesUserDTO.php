<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class GradesUserDTO
{
    #[Serializer\Type("Array<App\Dto\GradeDTO>")]
    public array $grades;
}