<?php

namespace App\Dto\SkillAssessment;

use JMS\Serializer\Annotation as Serializer;

class SkillAssessmentDTO
{
    #[Serializer\Type("integer")]
    public int $user_id;

    #[Serializer\Type("integer")]
    public int $skills_id;

    #[Serializer\Type("integer")]
    public int $estimation;

    #[Serializer\Type("DateTime<'Y-m-d'>")]
    public \DateTimeInterface $date;
}