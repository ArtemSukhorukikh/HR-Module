<?php

namespace App\Dto\Transformer\Response;

use App\Dto\ContactDTO;
use App\Dto\UserCurrentDto;
use App\Entity\Contacts;
use App\Entity\User;

class UserResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    /**
     * @param User $user
     */
    public function transformFromObject($user)
    {
        $dto = new UserCurrentDto();
        $dto->username = $user->getUserIdentifier();
        $dto->roles = $user->getRoles();
        return $dto;
    }
}