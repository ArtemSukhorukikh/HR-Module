<?php

namespace App\Dto\EducationResources;

use JMS\Serializer\Annotation as Serializer;

class EducationResourcesListDTO
{
    #[Serializer\Type("array<App\Dto\EducationResources\EducationResourcesDTO>")]
    public array $educationResourcesCompetence;
}