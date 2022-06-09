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
        $dto->applicationForTrainingListDTO = $this->applicationForTrainingUserResponse->transformFromObjects($users);
        return $dto;
    }

}