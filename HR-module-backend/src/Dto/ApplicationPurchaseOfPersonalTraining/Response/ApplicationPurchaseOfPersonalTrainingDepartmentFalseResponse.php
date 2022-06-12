<?php

namespace App\Dto\ApplicationPurchaseOfPersonalTraining\Response;

use App\Dto\ApplicationForTraining\ApplicationForTrainingDepartmentDTO;
use App\Dto\ApplicationForTraining\ApplicationForTrainingDTO;
use App\Dto\ApplicationForTraining\ApplicationForTrainingListDTO;
use App\Dto\ApplicationPurchaseOfPersonalTraining\ApplicationPurchaseOfPersonalTrainingListDTO;
use App\Dto\ApplicationPurchaseOfPersonalTraining\Response\ApplicationPurchaseOfPersonalTrainingResponse;
use App\Entity\ApplicationForTraining;
use App\Entity\Department;
use App\Entity\User;
use App\Repository\ApplicationForTrainingRepository;
use App\Repository\ApplicationPurchaseOfPersonalTrainingRepository;
use App\Repository\UserRepository;

class ApplicationPurchaseOfPersonalTrainingDepartmentFalseResponse
{

    private ApplicationPurchaseOfPersonalTrainingResponse $applicationPurchaseOfPersonalTrainingResponse;
    private ApplicationPurchaseOfPersonalTrainingRepository $applicationPurchaseOfPersonalTrainingRepository;
    private UserRepository $userRepository;

    public function __construct(ApplicationPurchaseOfPersonalTrainingResponse $applicationPurchaseOfPersonalTrainingResponse,
                                ApplicationPurchaseOfPersonalTrainingRepository $applicationPurchaseOfPersonalTrainingRepository,
                                UserRepository $userRepository)
    {
        $this->applicationPurchaseOfPersonalTrainingResponse = $applicationPurchaseOfPersonalTrainingResponse;
        $this->userRepository = $userRepository;
        $this->applicationPurchaseOfPersonalTrainingRepository = $applicationPurchaseOfPersonalTrainingRepository;
    }
    /**
     * @param Department $object
     */
    public function transformFromObject($object):ApplicationPurchaseOfPersonalTrainingListDTO
    {
        $dto = new ApplicationPurchaseOfPersonalTrainingListDTO();
        $users = $object->getUsers();
        $dto->applicationPurchaseOfPersonalTrainingDTO = [];
        foreach ($users as $user){
            $applications = $this->applicationPurchaseOfPersonalTrainingRepository->findBy(["user_" => $user->getId(), "status" => 0]);
            if ($applications != null) {
                $dto->applicationPurchaseOfPersonalTrainingDTO = array_merge($dto->applicationPurchaseOfPersonalTrainingDTO, $this->applicationPurchaseOfPersonalTrainingResponse->transformFromObjects($applications)) ;
            }
        }
        return $dto;
    }

}