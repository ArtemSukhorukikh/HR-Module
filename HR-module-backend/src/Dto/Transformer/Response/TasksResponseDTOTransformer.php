<?php

namespace App\Dto\Transformer\Response;

use App\Dto\ProjectDTO;
use App\Dto\TaskDTO;
use App\Entity\Projects;
use App\Entity\Task;

class TasksResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    public EvaluationResponseDTOTransformer $evaluationResponseDTOTransformer;

    public function __construct(EvaluationResponseDTOTransformer $evaluationResponseDTOTransformer)
    {
        $this->evaluationResponseDTOTransformer = $evaluationResponseDTOTransformer;
    }

    /**
     * @param Task $task
     */
    public function transformFromObject($task)
    {
        $dto = new TaskDTO();
        $dto->id = $task->getId();
        $dto->name = $task->getName();
        $dto->description = $task->getDescription();
        $dto->status = $task->getStatus();
        $dto->start_date = $task->getStartDate()->format("Y-m-d H-m");
        $closeDate = $task->getCloseDate();
        $dto->updated_on = $task->getUpdateOn()->format("Y-m-d H-m");
        if ($closeDate) {
            $dto->closed_on = $closeDate->format("Y-m-d H-m");
        }
        $dto->taskHours = $task->timeTask();
        if ($task){
            $dto->estimated_hours = $task->getEstimatedHours();
        }
        $users = $task->getUsers();
        if ($users) {
            foreach ($users as $user) {
                $dto->users[] = $user->getLastName() . "" . $user->getFirstName();
            }
        }else {
            $dto->users[] = "Задача не назначена";
        }
        if ($task->getTaskEvaluation()) {
            $dto->evaluation = $this->evaluationResponseDTOTransformer->transformFromObject($task->getTaskEvaluation());
        }
        $taskTimeEntites = $task->getTimeEntries();
        $dto->timeEntity = 0.0;
        foreach ($taskTimeEntites as $timeEntity) {
            $dto->timeEntity += $timeEntity->getHours();
        }
        return $dto;
    }
}
