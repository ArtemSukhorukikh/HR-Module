<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class TasksDTO
{
    #[Serializer\Type(TaskDTO::class)]
    public array $tasks;
}