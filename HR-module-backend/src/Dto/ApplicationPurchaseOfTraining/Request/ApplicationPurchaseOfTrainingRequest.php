<?php

namespace App\Dto\ApplicationPurchaseOfTraining\Request;

use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\ApplicationPurchaseOfTraining;

class ApplicationPurchaseOfTrainingRequest extends AbstractRequestDTOTransformer
{
    /**
     * @param ApplicationPurchaseOfTrainingDTO $object
     */
    public function transformToObject($object): ApplicationPurchaseOfTraining
    {
        $data = new ApplicationPurchaseOfTraining();
        $data->setDescription($object->description);
        $data->setLink($object->link);
        $data->setNote($object->note);
        $data->setStatus($object->status);
        return $data;
    }
}