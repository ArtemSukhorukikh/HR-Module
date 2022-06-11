<?php

namespace App\Dto\Competence;

use JMS\Serializer\Annotation as Serializer;

class CompetenceTestDTO
{
    #[Serializer\Type("array<integer>")]
    public array $skills_id;
}