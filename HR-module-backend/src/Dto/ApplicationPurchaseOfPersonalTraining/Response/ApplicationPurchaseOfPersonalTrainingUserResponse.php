<?php

namespace App\Dto\ApplicationPurchaseOfPersonalTraining\Response;

use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingDTO;
use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingListDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\User;
use App\Repository\ApplicationPurchaseOfTrainingRepository;

class ApplicationPurchaseOfPersonalTrainingUserResponse extends AbstractResponceDTOTransformer
{
    private ApplicationPurchaseOfTrainingRepository $applicationPurchaseOfTrainingRepository;

    public function __construct(ApplicationPurchaseOfTrainingRepository $applicationPurchaseOfTrainingRepository)
    {
        $this->applicationPurchaseOfTrainingRepository = $applicationPurchaseOfTrainingRepository;
    }
    /**
     * @param User $object
     */
    public function transformFromObject($object):ApplicationPurchaseOfTrainingListDTO
    {
        $dto = new ApplicationPurchaseOfTrainingListDTO();
        $application = $this->applicationPurchaseOfTrainingRepository->findBy(
            ["compose" => $object->getId()]
        );
        $dto->applicationPurchaseOfTrainingDTO = [];
        foreach ($application as $app)
        {
            $dto_ = new ApplicationPurchaseOfTrainingDTO();
            $dto_->userId = $app->getCompose()->getId();
            $dto_->description = $app->getDescription();
            $dto_->link = $app->getLink();
            $dto_->note = $app->getNote();
            $dto_->status = $app->getStatus();
            array_push($dto->applicationPurchaseOfTrainingDTO, $dto_);
        }
        return $dto;
    }
}