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

    #[Serializer\Type("integer")]
    public int $obeys_id;

    #[Serializer\Type("string")]
    public string $obeys_name;

    #[Serializer\Type("integer")]
    public int $dep_id;

    #[Serializer\Type("string")]
    public string $dep_name;

    #[Serializer\Type("string")]
    public string $director_id;

    #[Serializer\Type("string")]
    public string $director_name;
}