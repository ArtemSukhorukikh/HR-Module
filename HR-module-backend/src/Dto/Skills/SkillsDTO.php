<?php

namespace App\Dto\Skills;

use JMS\Serializer\Annotation as Serializer;

class SkillsDTO
{
    #[Serializer\Type("int")]
    public int $id;

    #[Serializer\Type("string")]
    public string $name;

    #[Serializer\Type("int")]
    public int $type;

    #[Serializer\Type("string")]
    public string $description;

    #[Serializer\Type("array<int>")]
    public array $competence_id;

    #[Serializer\Type("array<int>")]
    public array $skill_assessments;

}