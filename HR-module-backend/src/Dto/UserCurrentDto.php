<?php
namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class UserCurrentDto
{
    #[Serializer\Type("string")]
    public string $username;

    #[Serializer\Type("array")]
    public array $roles;

}