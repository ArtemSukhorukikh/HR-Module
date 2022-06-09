<?php

namespace App\Dto\Transformer\Request;

use App\Dto\ContactDTO;
use App\Dto\EvaluationDTO;
use App\Dto\NewContactsDTO;
use App\Entity\Contacts;
use App\Entity\TaskEvaluation;

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
        $data->setDate(\DateTime::createFromFormat("Y-m-d", $evaluation->date));
        return $data;
    }
}