<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class WorkplaceDTO
{
    #[Serializer\Type("integer")]
    public int $RoomInTheOffice = 1;

    #[Serializer\Type(UserCurrentDto::class)]
    public UserCurrentDto $user;
}