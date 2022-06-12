<?php

namespace App\Dto\ApplicationForTraining\Request;

use App\Dto\ApplicationForTraining\ApplicationForTrainingDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\ApplicationForTraining;
use App\Repository\EducationalResourcesRepository;
use App\Repository\UserRepository;

class ApplicationForTrainingRequest extends AbstractRequestDTOTransformer
{
    private UserRepository $userRepository;
    private EducationalResourcesRepository $educationalResourcesRepository;

    public function __construct(UserRepository $userRepository, EducationalResourcesRepository $educationalResourcesRepository)
    {
        $this->userRepository = $userRepository;
        $this->educationalResourcesRepository = $educationalResourcesRepository;
    }
    /**
     * @param ApplicationForTrainingDTO $object
     */
    public function transformToObject($object): ApplicationForTraining
    {
        $data = new ApplicationForTraining();
        $data->setCompose($this->userRepository->find($object->user_id));
        $data->setIncluded($this->educationalResourcesRepository->find($object->ed_res_id));
        $data->setStartDate($object->start_date);
        $data->setEndDate($object->end_date);
        $data->setMathodOfPassage($object->method_of_passage);
        $data->setNote($object->note);
        $data->setStatus($object->status);
        return $data;
    }
}