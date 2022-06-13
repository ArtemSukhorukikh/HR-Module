<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class ProjectAndTaskDTO
{
    #[Serializer\Type("integer")]
    public int $id;
    
    #[Serializer\Type("string")]
    public string $name;
    
    #[Serializer\Type("string")]
    public $description;

    #[Serializer\Type("string")]
    public $status;

    #[Serializer\Type("string")]
    public $created_on;

    #[Serializer\Type("string")]
    public $closed_on;

    #[Serializer\Type("string")]
    public array $team;

    #[Serializer\Type(TaskDTO::class)]
    public array $tasks;
}