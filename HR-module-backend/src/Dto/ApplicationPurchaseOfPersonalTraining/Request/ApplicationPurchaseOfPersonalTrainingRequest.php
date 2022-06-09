<?php

namespace App\Dto\ApplicationPurchaseOfPersonalTraining\Request;

use App\Dto\ApplicationPurchaseOfPersonalTraining\ApplicationPurchaseOfPersonalTrainingDTO;
use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\ApplicationPurchaseOfPersonalTraining;
use App\Entity\ApplicationPurchaseOfTraining;
use App\Repository\ApplicationPurchaseOfPersonalTrainingRepository;
use App\Repository\UserRepository;

class ApplicationPurchaseOfPersonalTrainingRequest extends AbstractRequestDTOTransformer
{

    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->$userRepository = $userRepository;
    }
    /**
     * @param ApplicationPurchaseOfPersonalTrainingDTO $object
     */
    public function transformToObject($object): ApplicationPurchaseOfPersonalTraining
    {
        $data = new ApplicationPurchaseOfPersonalTraining();
        $data->setUser($this->userRepository->find($object->userId));
        $data->setLink($object->link);
        $data->setNote($object->note);
        $data->setStatus($object->status);
        return $data;
    }
}