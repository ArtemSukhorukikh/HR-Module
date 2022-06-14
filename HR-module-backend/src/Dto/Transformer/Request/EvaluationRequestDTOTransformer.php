<?php

namespace App\Dto\Transformer\Request;

use App\Dto\EvaluationDTO;
use App\Entity\TaskEvaluation;
use DateTime;

class EvaluationRequestDTOTransformer extends AbstractRequestDTOTransformer
{
    /**
     * @param EvaluationDTO $evaluation
     */
    public function transformToObject($evaluation)
    {
        $data = new TaskEvaluation();
        $data->setDescription($evaluation->description);
        $data->setValue($evaluation->value);
        $data->setDate(new DateTime($evaluation->date));
        return $data;
    }
}