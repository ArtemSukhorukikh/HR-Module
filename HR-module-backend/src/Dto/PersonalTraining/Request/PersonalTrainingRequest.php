<?php

namespace App\Dto\PersonalTraining\Request;

use App\Dto\Feedback\FeedbackDTO;
use App\Dto\PersonalTraining\PersonalTrainingDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\ApplicationPurchaseOfPersonalTraining;
use App\Entity\Feedback;
use App\Entity\PersonalTraining;
use App\Repository\ApplicationPurchaseOfPersonalTrainingRepository;
use App\Repository\PersonalTrainingRepository;

class PersonalTrainingRequest extends AbstractRequestDTOTransformer
{
    private ApplicationPurchaseOfPersonalTrainingRepository $applicationPurchaseOfPersonalTrainingRepository;

    public function __construct(ApplicationPurchaseOfPersonalTrainingRepository $applicationPurchaseOfPersonalTrainingRepository)
    {
        $this->$applicationPurchaseOfPersonalTrainingRepository = $applicationPurchaseOfPersonalTrainingRepository;
    }
    /**
     * @param PersonalTrainingDTO $object
     */
    public function transformToObject($object)
    {
        $data = new PersonalTraining();
        $data->setContractNumber($object->contractNumber);
        $data->setDate($object->date);
        $data->setApplication($this->applicationPurchaseOfPersonalTrainingRepository->find($object->appId));
        return $data;
    }
}