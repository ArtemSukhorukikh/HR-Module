<?php

namespace App\Dto\ApplicationForTraining\Response;

use App\Dto\ApplicationForTraining\ApplicationForTrainingDTO;
use App\Dto\ApplicationForTraining\ApplicationPurchaseOfTrainingListDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\User;
use App\Repository\ApplicationForTrainingRepository;

class ApplicationForTrainingFindResponse extends AbstractResponceDTOTransformer
{
    private ApplicationForTrainingRepository $applicationForTrainingRepository;

    public function __construct(ApplicationForTrainingRepository $applicationForTrainingRepository)
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
        $dto->edResId = $application->getIncluded()->getId();
        $dto->startDate = $application->getStartDate();
        $dto->endDate = $application->getEndDate();
        $dto->mathodOfPassage = $application->getMathodOfPassage();
        $dto->note = $application->getNote();
        $dto->status = $application->getStatus();
        return $dto;
    }
}