<?php

namespace App\Dto\ApplicationPurchaseOfPersonalTraining\Request;

use App\Entity\ApplicationPurchaseOfPersonalTraining;
use App\Entity\ApplicationPurchaseOfTraining;
use App\Repository\ApplicationPurchaseOfPersonalTrainingRepository;
use App\Repository\ApplicationPurchaseOfTrainingRepository;

class ApplicationPurchaseOfPersonalTrainingStatusRequest
{
    private ApplicationPurchaseOfPersonalTrainingRepository $applicationPurchaseOfPersonalTrainingRepository;

    public function __construct(ApplicationPurchaseOfPersonalTrainingRepository $applicationPurchaseOfPersonalTrainingRepository)
    {
        $this->applicationPurchaseOfPersonalTrainingRepository = $applicationPurchaseOfPersonalTrainingRepository;
    }
    /**
     * @param integer $id
     * @param integer $status
     */
    public function transformToObject($id, $status): ApplicationPurchaseOfPersonalTraining
    {
        $data = new ApplicationPurchaseOfPersonalTraining();
        $data = $this->applicationPurchaseOfPersonalTrainingRepository->find($id);
        $data->setStatus($status);
        return $data;
    }
}