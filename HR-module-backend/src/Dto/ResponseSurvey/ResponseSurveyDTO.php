<?php

namespace App\Dto\ResponseSurvey;

use JMS\Serializer\Annotation as Serializer;

class ResponseSurveyDTO
{
    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("integer")]
    public int $userId;

    #[Serializer\Type("integer")]
    public int $surveyId;

    #[Serializer\Type("integer")]
    public int $answer;
}