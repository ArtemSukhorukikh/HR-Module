<?php

namespace App\Dto\ResponseSurvey\Response;

use App\Dto\ResponseSurvey\ResponseSurveyDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\ResponeSurvey;

class ResponseSurveyResponse extends AbstractResponceDTOTransformer
{
    /**
     * @param ResponeSurvey $object
     */
    public function transformFromObject($object): ResponseSurveyDTO
    {
        $dto = new ResponseSurveyDTO();
        $dto->id = $object->getId();
        $dto->userId = $object->getUser()->getId();
        $dto->surveyId = $object->getSurvey()->getId();
        $dto->answer = $object->getAnswer();
        return $dto;
    }
}