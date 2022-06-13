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

    #[Serializer\Type("integer")]
    public int $obeys_name;

    #[Serializer\Type("array<integer>")]
    public array $deps;

    #[Serializer\Type("string")]
    public string $director_id;

    #[Serializer\Type("string")]
    public string $director_name;
}