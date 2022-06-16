<?php
namespace App\Dto;

use App\Dto\Department\DepartmentDTO;
use JMS\Serializer\Annotation as Serializer;

class UserCurrentDto
{
    #[Serializer\Type("int")]
    public int $id;

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

    #[Serializer\Type("string")]
    public $department;

    #[Serializer\Type(ContactDTO::class)]
    public array $contacts;

    #[Serializer\Type("float")]
    public float $speed;

    #[Serializer\Type("float")]
    public float $hours;

    #[Serializer\Type("float")]
    public float $avgMark;

    #[Serializer\Type("float")]
    public float $avgAch;

    #[Serializer\Type("float")]
    public float $taskInWork;

    #[Serializer\Type(PersonalAchievementsDTO::class)]
    public array $achivments;

    #[Serializer\Type("float")]
    public float $effectiveness;

    #[Serializer\Type(NotificationDTO::class)]
    public array $notifications;

}