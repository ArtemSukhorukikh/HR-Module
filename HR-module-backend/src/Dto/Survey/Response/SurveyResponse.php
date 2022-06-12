<?php

namespace App\Dto\Survey\Response;

use App\Dto\Survey\SurveyDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\Survey;

class SurveyResponse extends AbstractResponceDTOTransformer
{
    /**
     * @param Survey $object
     */
    public function transformFromObject($object):SurveyDTO
    {
        $dto = new SurveyDTO();
        $dto->id = $object->getId();
        $dto->title = $object->getTitle();
        $dto->description = $object->getDescription();
        $dto->link = $object->getLink();
        $dto->status = $object->getStatus();
        return $dto;
    }
}