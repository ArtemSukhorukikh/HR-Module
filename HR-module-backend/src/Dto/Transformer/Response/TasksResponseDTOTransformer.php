<?php

namespace App\Dto\Transformer\Response;

use App\Dto\ProjectDTO;
use App\Dto\TasksDTO;
use App\Entity\Projects;
use App\Entity\Task;

class ProjectsResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    /**
     * @param Task $task
     */
    public function transformFromObject($task)
    {
        $dto = new TasksDTO();
        $dto->id = $task->getId();
        $dto->name = $task->getName();
        $dto->description = $task->getDescription();
        $dto->status = $task->getStatus();
        $dto->created_on = $task->getStartDate()->format("YYYY-MM-dd");
        $dto->closed_on = $task->getCloseDate()->format("YYYY-MM-dd");
        return $dto;
    }
}
