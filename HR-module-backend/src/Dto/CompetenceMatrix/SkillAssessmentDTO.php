<?php

namespace App\Dto\CompetenceMatrix;

use JMS\Serializer\Annotation as Serializer;

class SkillAssessmentDTO
{
    #[Serializer\Type("string")]
    public string $name;

    #[Serializer\Type("array<float>")]
    public array $skill_assessments;
}