<?php

namespace App\Dto\ApplicationPurchaseOfTraining\Request;

use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\ApplicationPurchaseOfTraining;
use App\Repository\UserRepository;

class ApplicationPurchaseOfTrainingRequest extends AbstractRequestDTOTransformer
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * @param ApplicationPurchaseOfTrainingDTO $object
     */
    public function transformToObject($object): ApplicationPurchaseOfTraining
    {
        $data = new ApplicationPurchaseOfTraining();
        $data->setCompose($this->userRepository->find($object->user_id));
        $data->setDescription($object->description);
        $data->setLink($object->link);
        $data->setNote($object->note);
        $data->setStatus($object->status);
        return $data;
    }
}