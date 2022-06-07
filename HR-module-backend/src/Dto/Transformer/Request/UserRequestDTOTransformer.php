<?php

namespace App\Dto\Transformer\Request;

use App\Dto\UserDto;
use App\Entity\User;
use DateTime;
use DateTimeInterface;

class UserRequestDTOTransformer extends AbstractRequestDTOTransformer
{
    /**
     * @param UserDto $user
     */
    public function transformToObject($user)
    {
        $data = new User;
        $data->setFirstName($user->firstname);
        $data->setLastName($user->lastname);
        $data->setPosition($user->position);
        $data->setPatronymic($user->patronymic);
        $data->setUsername($user->username);
        $data->setDateOfHiring(\DateTime::createFromFormat('Y-m-d', $user->dateofhiring));
        return $data;
    }
}