<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class PersonalAchievementsAddUserDTO
{
    #[Serializer\Type("string")]
    public string $username;

    #[Serializer\Type("integer")]
    public int $id;

}