<?php

namespace App\Dto\Competence;

use JMS\Serializer\Annotation as Serializer;

class CompetenceListDepDTO
{
    #[Serializer\Type("array<App\Dto\Competence\CompetenceDTO>")]
    public array $competence_dto_s;
}