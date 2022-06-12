<?php

namespace App\Dto\Survey;

use JMS\Serializer\Annotation as Serializer;

class SurveyListDTO
{
    #[Serializer\Type("array<App\Dto\SurveyDTO>")]
    public array $surveyListDTO;
}