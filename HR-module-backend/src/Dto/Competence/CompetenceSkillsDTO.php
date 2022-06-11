<?php

namespace App\Dto\Competence;

use JMS\Serializer\Annotation as Serializer;

class CompetenceSkillsDTO
{
    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("string")]
    public string $name;

    #[Serializer\Type("array<integer>")]
    public array $skills_id;
}