<?php

namespace App\Dto\ApplicationPurchaseOfPersonalTraining\Response;

use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingDepartmentDTO;
use App\Entity\Department;
use App\Repository\ApplicationPurchaseOfTrainingRepository;
use App\Repository\UserRepository;

class ApplicationPurchaseOfPersonalTrainingDepartmentResponse
{

    private ApplicationPurchaseOfPersonalTrainingUserResponse $applicationPurchaseOfTrainingUserResponse;
    private UserRepository $userRepository;

    public function __construct(ApplicationPurchaseOfPersonalTrainingUserResponse $applicationPurchaseOfTrainingUserResponse,
                                UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->applicationPurchaseOfTrainingUserResponse = $applicationPurchaseOfTrainingUserResponse;
    }
    /**
     * @param Department $object
     */
    public function transformFromObject($object):ApplicationPurchaseOfTrainingDepartmentDTO
    {
        $dto = new ApplicationPurchaseOfTrainingDepartmentDTO();
        $users = $this->userRepository->findBy(
            ["id" => $object->getId()]
        );
        $dto->applicationPurchaseOfTrainingListDTO = $this->applicationPurchaseOfTrainingUserResponse->transformFromObjects($users);
        return $dto;
    }

}