<?php

namespace App\Dto\Transformer\Response;

use App\Dto\EvaluationDTO;
use App\Entity\TaskEvaluation;


class EvaluationResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    /**
     * @param TaskEvaluation $te
     */
    public function transformFromObject($te): EvaluationDTO
    {
        $dto = new EvaluationDTO();
        $dto->id = $te->getId();
        $dto->description = $te->getDescription();
        $dto->value = $te->getValue();
        $dto->date = $te->getDate()->format("Y-m-d H-m");
        return $dto;
    }
}