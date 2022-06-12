<?php

namespace App\Dto\ApplicationForTraining\Response;

use App\Dto\ApplicationForTraining\ApplicationForTrainingDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\ApplicationForTraining;
use App\Repository\EducationalResourcesRepository;

class ApplicationForTrainingResponse extends AbstractResponceDTOTransformer
{
    /**
     * @param ApplicationForTraining $object
     */
    public function transformFromObject($object):ApplicationForTrainingDTO
    {
        $dto = new ApplicationForTrainingDTO();
        $dto->id = $object->getId();
        $dto->user_id = $object->getCompose()->getId();
        $dto->ed_name = $object->getIncluded()->getName();
        $dto->ed_res_id = $object->getIncluded()->getId();
        $dto->start_date = $object->getStartDate();
        $dto->end_date = $object->getEndDate();
        $dto->method_of_passage = $object->getMathodOfPassage();
        $dto->note = $object->getNote();
        $dto->status = $object->getStatus();
        return $dto;
    }
}