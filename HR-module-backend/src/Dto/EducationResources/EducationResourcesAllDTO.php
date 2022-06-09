<?php

namespace App\Dto\EducationResources;

use JMS\Serializer\Annotation as Serializer;

class EducationResourcesAllDTO
{
    #[Serializer\Type("array<App\Dto\EducationResourcesCompetenceDTO>")]
    public array $educationResourcesAll;
}