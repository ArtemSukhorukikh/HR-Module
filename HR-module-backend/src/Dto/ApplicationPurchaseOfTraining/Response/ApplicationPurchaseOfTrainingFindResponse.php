<?php

namespace App\Dto\ApplicationPurchaseOfTraining\Response;

use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingListDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Repository\ApplicationPurchaseOfTrainingRepository;

class ApplicationPurchaseOfTrainingFindResponse extends AbstractResponceDTOTransformer
{
    private ApplicationPurchaseOfTrainingRepository $applicationForTrainingRepository;

    public function __construct(ApplicationPurchaseOfTrainingRepository $applicationForTrainingRepository)
    {
        $this->applicationForTrainingRepository = $applicationForTrainingRepository;
    }
    /**
     * @param string $id
     */
    public function transformFromObject($id):ApplicationPurchaseOfTrainingListDTO
    {
        $dto = new ApplicationPurchaseOfTrainingListDTO();
        $application = $this->applicationForTrainingRepository->find($id);
        $dto->userId = $application->getCompose()->getId();
        $dto->description = $application->getDescription();
        $dto->link = $application->getLink();
        $dto->note = $application->getNote();
        $dto->status = $application->getStatus();
        return $dto;
    }
}