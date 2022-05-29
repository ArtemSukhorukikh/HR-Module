<?php

namespace App\Dto\Transformer\Request;

use App\Dto\ContactDTO;
use App\Dto\NewContactsDTO;
use App\Dto\OfficeDTO;
use App\Dto\WorkplaceDTO;
use App\Entity\Contacts;
use App\Entity\Office;
use App\Entity\Workplace;

class WorkplaceRequestDTOTransformer extends AbstractRequestDTOTransformer
{
    /**
     * @param WorkplaceDTO $workplace
     */
    public function transformToObject($workplace)
    {
        $data = new Workplace();
        $data->setRoomInTheOffice($workplace->RoomInTheOffice);
        return $data;
    }
}