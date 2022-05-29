<?php

namespace App\Dto\Transformer\Response;

use App\Dto\ContactDTO;
use App\Dto\PersonalAchievementsDTO;
use App\Entity\Contacts;
use App\Entity\PersonalAchievements;

class PersonalAchivmentsResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    /**
     * @param PersonalAchievements $achivment
     */
    public function transformFromObject($achivment)
    {
        $dto = new PersonalAchievementsDTO();
        $dto->name = $achivment->getName();
        $dto->description = $achivment->getDescription();
        $dto->value = $achivment->getValue();
        return $dto;
    }
}