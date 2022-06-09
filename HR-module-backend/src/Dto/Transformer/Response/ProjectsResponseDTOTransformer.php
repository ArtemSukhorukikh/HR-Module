<?php

namespace App\Dto\Transformer\Response;

use App\Dto\ProjectDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\Projects;

class ProjectsResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    /**
     * @param Projects $project
     */
    public function transformFromObject($project)
    {
        $dto = new ProjectDTO();
        $dto->id = $project->getId();
        $dto->name = $project->getName();
        $dto->description = $project->getDescription();
        $dto->status = $project->getStatus();
        $dto->created_on = $project->getCreatedOn()->format("Y-m-d");
        $clodeDate = $project->getClosedOn();
        if ($clodeDate) {
            $dto->closed_on = $clodeDate->format("YYYY-MM-dd");
        }
        return $dto;
    }
}
