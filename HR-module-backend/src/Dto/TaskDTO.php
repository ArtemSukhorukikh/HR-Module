<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class TaskDTO
{
    #[Serializer\Type("integer")]
    public int $id;
    
    #[Serializer\Type("string")]
    public string $name;
    
    #[Serializer\Type("string")]
    public string $description;

    #[Serializer\Type("string")]
    public string $status;

    #[Serializer\Type("string")]
    public string $start_date;

    #[Serializer\Type("string")]
    public string $closed_on;

    #[Serializer\Type("float")]
    public float $estimated_hours;
}