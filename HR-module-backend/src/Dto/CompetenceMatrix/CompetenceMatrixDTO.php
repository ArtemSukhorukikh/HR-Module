<?php

namespace App\Dto\CompetenceMatrix;

use JMS\Serializer\Annotation as Serializer;

class CompetenceMatrixDTO
{
    #[Serializer\Type("array<App\Dto\CompetenceMatrix\SkillAssessmentDTO>")]
    public array $skill_assessment;

    #[Serializer\Type("array<App\Dto\UserDto>")]
    public array $users;
}