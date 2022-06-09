<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class ContactDTO
{
    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("string")]
    public string $source;

    #[Serializer\Type("string")]
    public string $link;
}