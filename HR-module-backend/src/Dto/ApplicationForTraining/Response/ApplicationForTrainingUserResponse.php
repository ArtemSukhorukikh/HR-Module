<?php

namespace App\Dto\ApplicationForTraining\Response;

use App\Dto\ApplicationForTraining\ApplicationForTrainingDTO;
use App\Dto\ApplicationForTraining\ApplicationForTrainingListDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\ApplicationForTraining;
use App\Entity\User;
use App\Repository\ApplicationForTrainingRepository;

class ApplicationForTrainingUserResponse extends AbstractResponceDTOTransformer
{
    private ApplicationForTrainingRepository $applicationForTrainingRepository;

    public function __construct(ApplicationForTrainingRepository $applicationForTrainingRepository)
    {
        $this->applicationForTrainingRepository = $applicationForTrainingRepository;
    }
    /**
     * @param User $object
     */
    public function transformFromObject($object):ApplicationForTrainingListDTO
    {
        $dto = new ApplicationForTrainingListDTO();
        $application = $this->applicationForTrainingRepository->findBy(
            ["compose" => $object->getId()]
        );
        $dto->applicationForTrainingDTO = [];
        foreach ($application as $app)
        {
            $dto_ = new ApplicationForTrainingDTO();
            $dto_->userId = $app->getCompose()->getId();
            $dto_->edResId = $app->getIncluded()->getId();
            $dto_->startDate = $app->getStartDate();
            $dto_->endDate = $app->getEndDate();
            $dto_->mathodOfPassage = $app->getMathodOfPassage();
            $dto_->note = $app->getNote();
            $dto_->status = $app->getStatus();
            array_push($dto->applicationForTrainingDTO, $dto_);
        }
        return $dto;
    }
}