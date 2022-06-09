<?php

namespace App\Dto\EducationResources\Request;

use App\Dto\EducationResources\EducationResourcesDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\EducationalResources;

class EducationResourcesRequest extends AbstractRequestDTOTransformer
{
    /**
     * @param EducationResourcesDTO $object
     */
    public function transformToObject($object)
    {
        $data = new EducationalResources();
        $data->setName($object->name);
        $data->setLink($object->link);
        $data->setDescription($object->description);
        $data->setDate($object->date);
        $data->setPrice($object->price);
        $data->setType($object->type);
        return $data;
    }
}