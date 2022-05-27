<?php

namespace App\Dto;

use App\Entity\Contacts;
use JMS\Serializer\Annotation as Serializer;
use App\Dto\ContactDTO;

class NewContactsDTO
{
    #[Serializer\Type("string")]
    public string $username;
    #[Serializer\Type("string")]
    public string $link = "1";
    #[Serializer\Type("string")]
    public string $source = "2";
}