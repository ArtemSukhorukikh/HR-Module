<?php

namespace App\Dto\ApplicationPurchaseOfTraining\Request;

use App\Entity\ApplicationPurchaseOfTraining;
use App\Repository\ApplicationPurchaseOfTrainingRepository;

class ApplicationPurchaseOfTrainingStatusRequest
{
    private ApplicationPurchaseOfTrainingRepository $applicationPurchaseOfTrainingRepository;

    public function __construct(ApplicationPurchaseOfTrainingRepository $applicationPurchaseOfTrainingRepository)
    {
        $this->applicationPurchaseOfTrainingRepository = $applicationPurchaseOfTrainingRepository;
    }
    /**
     * @param integer $id
     * @param integer $status
     */
    public function transformToObject($id, $status): ApplicationPurchaseOfTraining
    {
        $data = new ApplicationPurchaseOfTraining();
        $data = $this->applicationPurchaseOfTrainingRepository->find($id);
        $data->setStatus($status);
        return $data;
    }
}