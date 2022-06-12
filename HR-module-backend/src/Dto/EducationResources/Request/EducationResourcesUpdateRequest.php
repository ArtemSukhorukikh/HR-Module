<?php

namespace App\Dto\EducationResources\Request;

use App\Dto\EducationResources\EducationResourcesUpdateDTO;
use App\Entity\EducationalResources;

class EducationResourcesUpdateRequest
{
    /**
     * @param EducationResourcesUpdateDTO $object
     */
    public function transformToObject($object)
    {
        $data = new EducationalResources();
        $data->setName($object->name);
        $data->setLink($object->link);
        $data->setDescription($object->description);
        return $data;
    }

}