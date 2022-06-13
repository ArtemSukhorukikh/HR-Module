<?php

namespace App\Dto\Department;

use JMS\Serializer\Annotation as Serializer;

class DepartmentDTO
{
    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("string")]
    public string $name;

    #[Serializer\Type("integer")]
    public int $main_competence_id;

    #[Serializer\Type("string")]
    public string $main_competence_name;

    #[Serializer\Type("integer")]
    public array $users;
}