<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class OfficeDTO
{
    #[Serializer\Type("string")]
    public string $name;

    #[Serializer\Type("integer")]
    public int $floor;

    #[Serializer\Type(WorkplaceDTO::class)]
    public array $workplaces;
}