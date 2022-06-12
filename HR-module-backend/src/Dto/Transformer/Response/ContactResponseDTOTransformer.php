<?php

namespace App\Dto\Transformer\Response;

use App\Dto\ContactDTO;
use App\Entity\Contacts;

class ContactResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    /**
     * @param Contacts $contact
     */
    public function transformFromObject($contact)
    {
        $dto = new ContactDTO();
        $dto->id = $contact->getId();
        $dto->link = $contact->getlink();
        $dto->sourse = $contact->getSource();
        return $dto;
    }
}