<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class ProjectDTO
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
}