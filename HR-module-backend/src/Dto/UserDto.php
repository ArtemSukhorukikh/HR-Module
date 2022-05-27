<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    #[Serializer\Type("string")]
    #[Assert\NotBlank(message: 'The username field can\'t be blank.')]
    public string $username;

    #[Serializer\Type("string")]
    #[Assert\NotBlank(message: 'The password field can\'t be blank.')]
    #[Assert\Length(min: 6, minMessage: 'The password must be at least {{ limit }} characters.')]
    public string $password;
}