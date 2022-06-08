<?php

namespace App\Dto\Survey;

use JMS\Serializer\Annotation as Serializer;

class SurveyDTO
{
    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("string")]
    public string $title;

    #[Serializer\Type("string")]
    public string $description;

    #[Serializer\Type("string")]
    public string $link;

    #[Serializer\Type("integer")]
    public int $status;
}