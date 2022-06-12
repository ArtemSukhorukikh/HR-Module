<?php

namespace App\Dto\ApplicationPurchaseOfTraining\Response;

use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingDepartmentDTO;
use App\Dto\ApplicationPurchaseOfTraining\ApplicationPurchaseOfTrainingListDTO;
use App\Entity\Department;
use App\Repository\ApplicationPurchaseOfTrainingRepository;
use App\Repository\UserRepository;

class ApplicationPurchaseOfTrainingDepartmentFalseResponsegDepartmentResponse
{

    private ApplicationPurchaseOfTrainingResponse $applicationPurchaseOfTrainingResponse;
    private ApplicationPurchaseOfTrainingRepository $applicationPurchaseOfTrainingRepository;

    public function __construct(ApplicationPurchaseOfTrainingResponse $applicationPurchaseOfTrainingResponse,
                                ApplicationPurchaseOfTrainingRepository $applicationPurchaseOfTrainingRepository)
    {
        $this->applicationPurchaseOfTrainingRepository = $applicationPurchaseOfTrainingRepository;
        $this->applicationPurchaseOfTrainingResponse = $applicationPurchaseOfTrainingResponse;
    }
    /**
     * @param Department $object
     */
    public function transformFromObject($object):ApplicationPurchaseOfTrainingListDTO
    {
        $dto = new ApplicationPurchaseOfTrainingListDTO();
        $users = $object->getUsers();
        $dto->applicationPurchaseOfTrainingDTO = [];
        foreach ($users as $user){
            $applications = $this->applicationPurchaseOfTrainingRepository->findBy(["compose" => $user->getId(), "status" => 0]);
            if ($applications != null) {
                $dto->applicationPurchaseOfTrainingDTO = array_merge($dto->applicationPurchaseOfTrainingDTO, $this->applicationPurchaseOfTrainingResponse->transformFromObjects($applications)) ;
            }
        }
        return $dto;
    }

}