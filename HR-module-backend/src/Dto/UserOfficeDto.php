<?php
namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class UserOfficeDto
{
    #[Serializer\Type("int")]
    public int $id;

    #[Serializer\Type("string")]
    public string $username;


    #[Serializer\Type(UserDto::class)]
    public $userInfo;


    #[Serializer\Type(ContactDTO::class)]
    public array $contacts;


}