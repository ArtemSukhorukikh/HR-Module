<?php

namespace App\Dto;

use App\Entity\Projects;
use JMS\Serializer\Annotation as Serializer;

class ProjectsDTO
{
    #[Serializer\Type(ProjectDTO::class)]
    public array $projects;

}