<?php

namespace App\Dto\Transformer\Request;

use App\Dto\ContactDTO;
use App\Dto\GradeDTO;
use App\Dto\NewContactsDTO;
use App\Entity\Contacts;
use App\Entity\Grade;

class GradeRequestDTOTransformer extends AbstractRequestDTOTransformer
{
    /**
     * @param GradeDTO $grade
     */
    public function transformToObject($grade)
    {
        $data = new Grade();
        $data->setName((string)$grade->name);
        return $data;
    }
}