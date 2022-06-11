<?php

namespace App\Dto\Department\Response;

use App\Dto\Department\DepartmentDTO;
use App\Dto\Department\DepartmentUsersDTO;
use App\Dto\UserDto;
use App\Entity\Department;

class DepartmentUsersResponse
{
    /**
     * @param Department $object
     */
    public function transformFromObject($object): DepartmentUsersDTO
    {
        $dto = new DepartmentUsersDTO();
        $users = $object->getUsers();
        foreach ($users as $user)
        {
            $dto_ = new UserDto();
            $dto_->id = $user->getId();
            $dto_->lastname = $user->getLastName();
            $dto_->firstname = $user->getFirstName();
            $dto->users[] = $dto_;
        }
        return $dto;
    }
}