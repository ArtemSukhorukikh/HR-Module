<?php

namespace App\Dto\ApplicationPurchaseOfPersonalTraining\Response;

use App\Dto\ApplicationPurchaseOfPersonalTraining\ApplicationPurchaseOfPersonalTrainingListDTO;
use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingListDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Repository\ApplicationPurchaseOfPersonalTrainingRepository;
use App\Repository\ApplicationPurchaseOfTrainingRepository;

class ApplicationPurchaseOfPersonalTrainingFindResponse extends AbstractResponceDTOTransformer
{
    private ApplicationPurchaseOfPersonalTrainingRepository $applicationForTrainingRepository;

    public function __construct(ApplicationPurchaseOfPersonalTrainingRepository $applicationForTrainingRepository)
    {
        $this->applicationForTrainingRepository = $applicationForTrainingRepository;
    }
    /**
     * @param string $id
     */
    public function transformFromObject($id):ApplicationPurchaseOfPersonalTrainingListDTO
    {
        $dto = new ApplicationPurchaseOfPersonalTrainingListDTO();
        $application = $this->applicationForTrainingRepository->find($id);
        $dto->userId = $application->getUser()->getId();
        $dto->link = $application->getLink();
        $dto->note = $application->getNote();
        $dto->status = $application->getStatus();
        return $dto;
    }
}