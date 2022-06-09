<?php

namespace App\Dto\EducationResources\Response;

use App\Dto\EducationResources\EducationResourcesDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\EducationalResources;

class EducationResourcesResponse extends AbstractResponceDTOTransformer
{
    /**
     * @param EducationalResources $object
     */
    public function transformFromObject($object): EducationResourcesDTO
    {
        $dto = new EducationResourcesDTO();
        $dto->price = $object->getPrice();
        $dto->description = $object->getDescription();
        $dto->link = $object->getLink();
        $dto->name = $object->getName();
        $dto->id = $object->getId();
        $dto->date = $object->getDate();
        $dto->type = $object->getType();
        return $dto;
    }
}