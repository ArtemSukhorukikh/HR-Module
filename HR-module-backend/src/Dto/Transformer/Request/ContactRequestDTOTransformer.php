<?php

namespace App\Dto\Transformer\Request;

use App\Dto\ContactDTO;
use App\Dto\NewContactsDTO;
use App\Entity\Contacts;

class ContactRequestDTOTransformer extends AbstractRequestDTOTransformer
{
    /**
     * @param NewContactsDTO $contact
     */
    public function transformToObject($contact)
    {
        $data = new Contacts();
        $data->setlink((string)$contact->link);
        $data->setSource((string)$contact->source);
        return $data;
    }
}