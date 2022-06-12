<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class ContactDTO
{
    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("string")]
    public string $sourse;

    #[Serializer\Type("string")]
    public string $link;
}