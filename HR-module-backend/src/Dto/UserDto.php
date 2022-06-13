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

    #[Serializer\Type("string")]
    #[Assert\NotBlank(message: 'The username field can\'t be blank.')]
    public string $lastname;
    #[Serializer\Type("string")]
    #[Assert\NotBlank(message: 'The username field can\'t be blank.')]
    public string $firstname;
    #[Serializer\Type("string")]
    #[Assert\NotBlank(message: 'The username field can\'t be blank.')]
    public string $patronymic    ;
    #[Serializer\Type("string")]
    #[Assert\NotBlank(message: 'The username field can\'t be blank.')]
    public string $position;
    #[Serializer\Type("string")]
    #[Assert\NotBlank(message: 'The username field can\'t be blank.')]
    public string $dateofhiring;

    #[Serializer\Type("string")]
    public string $department;

    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("float")]
    public float $rating;
}