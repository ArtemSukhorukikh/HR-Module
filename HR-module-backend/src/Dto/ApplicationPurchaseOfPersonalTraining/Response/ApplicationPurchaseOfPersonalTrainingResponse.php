<?php

namespace App\Dto\ApplicationPurchaseOfPersonalTraining\Response;

use App\Dto\ApplicationForTraining\ApplicationForTrainingDTO;
use App\Dto\ApplicationPurchaseOfPersonalTraining\ApplicationPurchaseOfPersonalTrainingDTO;
use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingDTO;
use App\Entity\ApplicationForTraining;
use App\Entity\ApplicationPurchaseOfPersonalTraining;
use App\Entity\ApplicationPurchaseOfTraining;

class ApplicationPurchaseOfPersonalTrainingResponse
{
    /**
     * @param ApplicationPurchaseOfPersonalTraining $object
     */
    public function transformFromObject($object): ApplicationPurchaseOfPersonalTrainingDTO
    {
        $dto = new ApplicationPurchaseOfPersonalTrainingDTO();
        $dto->user_id = $object->getUser()->getId();
        $dto->link = $object->getLink();
        $dto->note = $object->getNote();
        $dto->status = $object->getStatus();
        return $dto;
    }
}