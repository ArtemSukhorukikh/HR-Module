<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class ContactDTO
{
    #[Serializer\Type("string")]
    public string $source;

    #[Serializer\Type("string")]
    public string $link;
}