<?php

namespace App\Dto\Transformer\Request;

use App\Dto\ContactDTO;
use App\Dto\NewContactsDTO;
use App\Dto\OfficeDTO;
use App\Entity\Contacts;
use App\Entity\Office;

class OfficeRequestDTOTransformer extends AbstractRequestDTOTransformer
{
    /**
     * @param OfficeDTO $office
     */
    public function transformToObject($office)
    {
        $data = new Office();
        $data->setFloor($office->floor);
        $data->setName($office->name);
        return $data;
    }
}