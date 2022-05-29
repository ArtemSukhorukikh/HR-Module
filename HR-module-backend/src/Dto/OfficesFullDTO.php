<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class OfficesFullDTO
{
    #[Serializer\Type(OfficeDTO::class)]
    public array $offices;

}