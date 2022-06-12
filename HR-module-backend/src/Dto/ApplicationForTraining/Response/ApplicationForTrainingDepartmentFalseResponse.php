<?php

namespace App\Dto\ApplicationForTraining\Response;

use App\Dto\ApplicationForTraining\ApplicationForTrainingDepartmentDTO;
use App\Dto\ApplicationForTraining\ApplicationForTrainingDTO;
use App\Dto\ApplicationForTraining\ApplicationForTrainingListDTO;
use App\Entity\ApplicationForTraining;
use App\Entity\Department;
use App\Entity\User;
use App\Repository\ApplicationForTrainingRepository;
use App\Repository\UserRepository;

class ApplicationForTrainingDepartmentFalseResponse
{

    private ApplicationForTrainingResponse $applicationForTrainingResponse;
    private ApplicationForTrainingRepository $applicationForTrainingRepository;
    private UserRepository $userRepository;

    public function __construct(ApplicationForTrainingResponse $applicationForTrainingResponse,
                                ApplicationForTrainingRepository $applicationForTrainingRepository,
                                UserRepository $userRepository)
    {
        $this->applicationForTrainingRepository = $applicationForTrainingRepository;
        $this->userRepository = $userRepository;
        $this->applicationForTrainingResponse = $applicationForTrainingResponse;
    }
    /**
     * @param Department $object
     */
    public function transformFromObject($object):ApplicationForTrainingListDTO
    {
        $dto = new ApplicationForTrainingListDTO();
        $users = $object->getUsers();
        $dto->applicationForTrainingDTO = [];
        foreach ($users as $user){
            $applications = $this->applicationForTrainingRepository->findBy(["compose" => $user->getId(), "status" => 0]);
            if ($applications != null) {
                $dto->applicationForTrainingDTO = array_merge($dto->applicationForTrainingDTO, $this->applicationForTrainingResponse->transformFromObjects($applications)) ;
            }
        }
        return $dto;
    }

}