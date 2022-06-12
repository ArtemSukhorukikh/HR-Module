<?php

namespace App\Dto\Transformer\Response;

use App\Dto\ProjectAndTaskDTO;
use App\Entity\Projects;

class ProjectAndTasksResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    public TasksResponseDTOTransformer $tasksResponseDTOTransformer;
    public function __construct(TasksResponseDTOTransformer $tasksResponseDTOTransformer)
    {
        $this->tasksResponseDTOTransformer = $tasksResponseDTOTransformer;
    }

    /**
     * @param Projects $project
     */
    public function transformFromObject($project)
    {
        $dto = new ProjectAndTaskDTO();
        $dto->id = $project->getId();
        $dto->name = $project->getName();
        $dto->description = $project->getDescription();
        $dto->status = $project->getStatus();
        $dto->created_on = $project->getCreatedOn()->format("Y-m-d");
        $clodeDate = $project->getClosedOn();
        if ($clodeDate) {
            $dto->closed_on = $clodeDate->format("YYYY-MM-dd");
        }
        $dto->tasks =  $this->tasksResponseDTOTransformer->transformFromObjects($project->getTasks());
        return $dto;
    }
}
