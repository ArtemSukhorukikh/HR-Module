<?php

namespace App\Dto;

use JMS\Serializer\Annotation as Serializer;

class PersonalAchievementsDTO
{
    #[Serializer\Type("string")]
    public string $name;

    #[Serializer\Type("string")]
    public string $description;

    #[Serializer\Type("float")]
    public float $value;
}