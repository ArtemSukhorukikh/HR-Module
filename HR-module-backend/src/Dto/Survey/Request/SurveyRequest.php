<?php

namespace App\Dto\Survey\Request;

use App\Dto\Survey\SurveyDTO;
use App\Entity\Survey;

class SurveyRequest
{
    /**
     * @param SurveyDTO $object
     */
    public function transformToObject($object): Survey
    {
        $data = new Survey();
        $data->setTitle($object->title);
        $data->setDescription($object->description);
        $data->setLink($object->link);
        $data->setStatus($object->status);
        return $data;
    }
}