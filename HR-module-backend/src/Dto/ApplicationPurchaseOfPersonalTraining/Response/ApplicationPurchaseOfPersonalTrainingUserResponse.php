<?php

namespace App\Dto\ApplicationPurchaseOfPersonalTraining\Response;

use App\Dto\ApplicationPurchaseOfPersonalTraining\ApplicationPurchaseOfPersonalTrainingDTO;
use App\Dto\ApplicationPurchaseOfPersonalTraining\ApplicationPurchaseOfPersonalTrainingListDTO;
use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingDTO;
use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingListDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\User;
use App\Repository\ApplicationPurchaseOfPersonalTrainingRepository;
use App\Repository\ApplicationPurchaseOfTrainingRepository;

class ApplicationPurchaseOfPersonalTrainingUserResponse extends AbstractResponceDTOTransformer
{
    private ApplicationPurchaseOfPersonalTrainingRepository $applicationPurchaseOfPersonalTrainingRepository;

    public function __construct(ApplicationPurchaseOfPersonalTrainingRepository $applicationPurchaseOfPersonalTrainingRepository)
    {
        $this->applicationPurchaseOfPersonalTrainingRepository = $applicationPurchaseOfPersonalTrainingRepository;
    }
    /**
     * @param User $object
     */
    public function transformFromObject($object):ApplicationPurchaseOfPersonalTrainingListDTO
    {
        $dto = new ApplicationPurchaseOfPersonalTrainingListDTO();
        $application = $this->applicationPurchaseOfPersonalTrainingRepository->findBy(
            ["user_" => $object->getId()]
        );
        $dto->applicationPurchaseOfPersonalTrainingDTO = [];
        foreach ($application as $app)
        {
            $dto_ = new ApplicationPurchaseOfTrainingDTO();
            $dto_->id=$app->getId();
            $dto_->user_id = $app->getUser()->getId();
            $dto_->link = $app->getLink();
            $dto_->note = $app->getNote();
            $dto_->status = $app->getStatus();
            $dto->applicationPurchaseOfPersonalTrainingDTO[] =  $dto_;
        }
        return $dto;
    }
}