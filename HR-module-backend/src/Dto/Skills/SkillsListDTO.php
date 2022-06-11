<?php

namespace App\Dto\Skills;

use JMS\Serializer\Annotation as Serializer;

class SkillsListDTO
{
    #[Serializer\Type("array<App\Dto\Skills\SkillsDTO>")]
    public array $skills;
}