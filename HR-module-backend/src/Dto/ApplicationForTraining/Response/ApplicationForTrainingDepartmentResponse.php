<?php

namespace App\Dto\ApplicationForTraining\Response;

use App\Dto\ApplicationForTraining\ApplicationForTrainingDepartmentDTO;
use App\Dto\ApplicationForTraining\ApplicationForTrainingDTO;
use App\Dto\ApplicationForTraining\ApplicationForTrainingListDTO;
use App\Entity\Department;
use App\Entity\User;
use App\Repository\ApplicationForTrainingRepository;
use App\Repository\UserRepository;

class ApplicationForTrainingDepartmentResponse
{

    private ApplicationForTrainingUserResponse $applicationForTrainingUserResponse;
    private ApplicationForTrainingRepository $applicationForTrainingRepository;
    private UserRepository $userRepository;

    public function __construct(ApplicationForTrainingRepository $applicationForTrainingRepository,
                                ApplicationForTrainingUserResponse $applicationForTrainingUserResponse,
                                UserRepository $userRepository)
    {
        $this->applicationForTrainingRepository = $applicationForTrainingRepository;
        $this->userRepository = $userRepository;
        $this->applicationForTrainingUserResponse = $applicationForTrainingUserResponse;
    }
    /**
     * @param Department $object
     */
    public function transformFromObject($object):ApplicationForTrainingDepartmentDTO
    {
        $dto = new ApplicationForTrainingDepartmentDTO();
        $users = $this->userRepository->findBy(
            ["id" => $object->getId()]
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