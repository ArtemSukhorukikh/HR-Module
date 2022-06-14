<?php

namespace App\Dto\DevelopmentPlan\Response;

use App\Dto\DevelopmentPlan\DevelopmentPlanDTO;
use App\Dto\DevelopmentPlan\DevelopmentPlanListDTO;
use App\Entity\Department;
use App\Repository\UserRepository;
use DateTime;

class DevelopmentPlanResponse
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * @param Department $object
     */
    public function transformFromObject($object): DevelopmentPlanListDTO
    {
        $dto = new DevelopmentPlanListDTO();
        $users = $object->getUsers();
        $date = new DateTime;
        $dto->dev_plan = [];
        foreach ($users as $user)
        {
            $apps = $user->getApplicationForTrainings();
            foreach ($apps as $app){
                if ($app->getEndDate() > $date && $app->getStatus() == 1){
                    $dto_ = new DevelopmentPlanDTO();
                    $dto_->name = $user->getFirstName().' '.$user->getLastName();
                    $dto_->start_date = $app->getStartDate();
                    $dto_->end_date = $app->getEndDate();
                    $dto_->type = $app->getMathodOfPassage();
                    $dto_->position = $user->getPosition();
                    $dto_->res_name = $app->getIncluded()->getName();
                    $competence = $user->getWorks()->getMainCompetence();
                    $dto_->comp_name = $this->userRepository->checkGrade($user, $competence)->getName();
                    $dto->dev_plan[] = $dto_;
                }
            }
        }
        return $dto;
    }
}