<?php

namespace App\Dto\Skills\Response;

use App\Dto\Skills\SkillsDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\Skills;

class SkillsResponse extends AbstractResponceDTOTransformer
{
    /**
     * @param Skills $object
     */
    public function transformFromObject($object): SkillsDTO
    {
        $dto = new SkillsDTO();
        $dto->id = $object->getId();
        $dto->name = $object->getName();
        $dto->type = $object->getType();
        $dto->description = $object->getDescription();
        return $dto;
    }

}