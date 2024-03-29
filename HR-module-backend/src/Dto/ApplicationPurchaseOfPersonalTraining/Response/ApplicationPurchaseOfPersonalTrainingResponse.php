<?php

namespace App\Dto\ApplicationPurchaseOfPersonalTraining\Response;

use App\Dto\ApplicationForTraining\ApplicationForTrainingDTO;
use App\Dto\ApplicationPurchaseOfPersonalTraining\ApplicationPurchaseOfPersonalTrainingDTO;
use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\ApplicationForTraining;
use App\Entity\ApplicationPurchaseOfPersonalTraining;
use App\Entity\ApplicationPurchaseOfTraining;

class ApplicationPurchaseOfPersonalTrainingResponse extends AbstractResponceDTOTransformer
{
    /**
     * @param ApplicationPurchaseOfPersonalTraining $object
     */
    public function transformFromObject($object): ApplicationPurchaseOfPersonalTrainingDTO
    {
        $dto = new ApplicationPurchaseOfPersonalTrainingDTO();
        $dto->id = $object->getId();
        $dto->user_id = $object->getUser()->getId();
        $dto->user_id = $object->getUser()->getId();
        $dto->user_username = $object->getUser()->getUsername();
        $dto->user_name = $object->getUser()->getFirstName().' '.$object->getUser()->getLastName();
        $dto->link = $object->getLink();
        $dto->note = $object->getNote();
        $dto->status = $object->getStatus();
        return $dto;
    }
}