<?php

namespace App\Dto\Transformer\Response;

use App\Dto\ProjectDTO;
use App\Dto\TaskDTO;
use App\Entity\Projects;
use App\Entity\Task;

class TasksResponseDTOTransformer extends AbstractResponceDTOTransformer
{
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
        if ($closeDate) {
            $dto->closed_on = $closeDate->format("Y-m-d H-m");
        }
        return $dto;
    }
}
