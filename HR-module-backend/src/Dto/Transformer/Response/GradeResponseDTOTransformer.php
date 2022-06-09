<?php

namespace App\Dto\Transformer\Response;

use App\Dto\AnswearDTO;
use App\Dto\GradeDTO;
use App\Dto\WorkplaceDTO;
use App\Entity\Grade;
use App\Entity\Workplace;


class GradeResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    /**
     * @param Grade $grade
     */
    public function transformFromObject($grade): GradeDTO
    {
        $dto = new GradeDTO();
        $dto->id = $grade->getId();
        $dto->name = $grade->getName();
        return $dto;
    }
}