<?php

namespace App\Dto;

use App\Entity\Contacts;
use JMS\Serializer\Annotation as Serializer;

class UsersContactsDTO
{
    #[Serializer\Type("array<App\Dto\ContactDTO>")]
    public array $contacts;
}