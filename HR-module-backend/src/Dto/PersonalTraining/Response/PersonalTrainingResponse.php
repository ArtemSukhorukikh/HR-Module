<?php

namespace App\Dto\PersonalTraining\Response;

use App\Dto\Feedback\FeedbackDTO;
use App\Dto\PersonalTraining\PersonalTrainingDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\Feedback;
use App\Entity\PersonalTraining;

class PersonalTrainingResponse extends AbstractResponceDTOTransformer
{
    /**
     * @param PersonalTraining $object
     */
    public function transformFromObject($object): PersonalTrainingDTO
    {
        $dto = new PersonalTrainingDTO();
        $dto->id = $object->getId();
        $dto->appId = $object->getApplication()->getId();
        $dto->contractNumber = $object->getContractNumber();
        $dto->date = $object->getDate();
        return $dto;
    }
}