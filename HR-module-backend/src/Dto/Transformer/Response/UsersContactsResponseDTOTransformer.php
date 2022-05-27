<?php

namespace App\Dto\Transformer\Response;

use App\Dto\UsersContactsDTO;
use App\Entity\User;

class UsersContactsResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    private ContactResponseDTOTransformer $contactResponseDTOTransformer;
    public function __construct(ContactResponseDTOTransformer $contactResponseDTOTransformer)
    {
        $this->contactResponseDTOTransformer = $contactResponseDTOTransformer;
    }

    /**
     * @param User $user
     */
    public function transformFromObject($user)
    {
        $dto = new UsersContactsDTO();
        $dto->contacts = $this->contactResponseDTOTransformer->transformFromObjects($user->getContacts());
        return $dto;
    }
}