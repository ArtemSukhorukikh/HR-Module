<?php

namespace App\Dto\ResponseSurvey;

use JMS\Serializer\Annotation as Serializer;

class ResponseSurveyListDTO
{
    #[Serializer\Type("array<App\Dto\ResponseSurveyDTO>")]
    public array $responseSurveyAll;
}