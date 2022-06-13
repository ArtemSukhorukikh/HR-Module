<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class UsersDto
{
    #[Serializer\Type(UserCurrentDto::class)]
    public array $users;

}