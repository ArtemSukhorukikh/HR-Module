<?php

namespace App\Dto\ApplicationForTraining\Response;

use App\Dto\ApplicationForTraining\ApplicationForTrainingDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\ApplicationForTraining;

class ApplicationForTrainingResponse extends AbstractResponceDTOTransformer
{
    /**
     * @param ApplicationForTraining $object
     */
    public function transformFromObject($object):ApplicationForTrainingDTO
    {
        $dto = new ApplicationForTrainingDTO();
        $dto->userId = $object->getCompose()->getId();
        $dto->edResId = $object->getIncluded()->getId();
        $dto->startDate = $object->getStartDate();
        $dto->endDate = $object->getEndDate();
        $dto->mathodOfPassage = $object->getMathodOfPassage();
        $dto->note = $object->getNote();
        $dto->status = $object->getStatus();
        return $dto;
    }
}