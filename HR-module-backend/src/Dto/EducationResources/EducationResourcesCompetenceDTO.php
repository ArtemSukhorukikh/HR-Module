<?php

namespace App\Dto\EducationResources;

use JMS\Serializer\Annotation as Serializer;

class EducationResourcesCompetenceDTO
{
    #[Serializer\Type("string")]
    public string $competence;
    #[Serializer\Type("array<App\Dto\EducationResources\EducationResourcesDTO>")]
    public array $educationResourcesCompetence;
}