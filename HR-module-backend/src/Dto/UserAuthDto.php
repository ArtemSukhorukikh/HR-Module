<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;
class UserAuthDto
{
    #[Serializer\Type("string")]
    public string $token;

    public array $roles;
}