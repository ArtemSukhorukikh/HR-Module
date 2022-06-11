<?php

namespace App\Dto\Department;

use JMS\Serializer\Annotation as Serializer;

class DepartmentUsersDTO
{
    #[Serializer\Type("array<App\Dto\UserDto>")]
    public array $users;
}