<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class WorkplaceDTO
{
    #[Serializer\Type("integer")]
    public int $id = 1;
    #[Serializer\Type("integer")]
    public int $RoomInTheOffice = 1;

    #[Serializer\Type(UserOfficeDto::class)]
    public UserOfficeDto $user;
}