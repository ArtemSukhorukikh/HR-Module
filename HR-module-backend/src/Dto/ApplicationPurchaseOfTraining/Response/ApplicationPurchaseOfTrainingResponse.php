<?php

namespace App\Dto\ApplicationPurchaseOfTraining\Response;

use App\Dto\ApplicationForTraining\ApplicationForTrainingDTO;
use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\ApplicationForTraining;
use App\Entity\ApplicationPurchaseOfTraining;

class ApplicationPurchaseOfTrainingResponse extends AbstractResponceDTOTransformer
{
    /**
     * @param ApplicationPurchaseOfTraining $object
     */
    public function transformFromObject($object): ApplicationPurchaseOfTrainingDTO
    {
        $dto = new ApplicationPurchaseOfTrainingDTO();
        $dto->id = $object->getId();
        $dto->user_name = $object->getCompose()->getFirstName().' '.$object->getCompose()->getLastName();
        $dto->description = $object->getDescription();
        $dto->link = $object->getLink();
        $dto->note = $object->getNote();
        $dto->status = $object->getStatus();
        return $dto;
    }
}