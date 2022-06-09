<?php
namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class UserCurrentDto
{
    #[Serializer\Type("string")]
    public string $username;

    #[Serializer\Type("array")]
    public array $roles;

    #[Serializer\Type(UserDto::class)]
    public $userInfo;

    #[Serializer\Type(ProjectsDTO::class)]
    public $projects;

    #[Serializer\Type(TasksDTO::class)]
    public $tasks;

    #[Serializer\Type(ContactDTO::class)]
    public array $contacts;


}