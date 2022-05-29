<?php

namespace App\Dto\Transformer\Request;

use App\Dto\ContactDTO;
use App\Dto\GradeDTO;
use App\Dto\NewContactsDTO;
use App\Dto\PersonalAchievementsDTO;
use App\Entity\Contacts;
use App\Entity\Grade;
use App\Entity\PersonalAchievements;

class PersonalAchievementsRequestDTOTransformer extends AbstractRequestDTOTransformer
{
    /**
     * @param PersonalAchievementsDTO $acivment
     */
    public function transformToObject($acivment)
    {
        $data = new PersonalAchievements();
        $data->setName($acivment->name);
        $data->setDescription($acivment->description);
        $data->setValue($acivment->value);
        return $data;
    }
}