<?php

namespace App\Dto\EducationResources;

use JMS\Serializer\Annotation as Serializer;

class EducationResourcesUpdateDTO
{
    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("string")]
    public string $name;

    #[Serializer\Type("string")]
    public string $description;

    #[Serializer\Type("string")]
    public string $link;
}