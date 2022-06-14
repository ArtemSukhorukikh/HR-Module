<?php

namespace App\Dto\Department;

use JMS\Serializer\Annotation as Serializer;

class DepartmentListDTO
{
    #[Serializer\Type("array<App\Dto\Department\DepartmentDTO>")]
    public array $departsments;
}