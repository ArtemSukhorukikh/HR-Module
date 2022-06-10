<?php

namespace App\Dto\EducationResources;

use JMS\Serializer\Annotation as Serializer;

class EducationResourcesTestDTO
{
    #[Serializer\Type("integer")]
    public int $id;

    #[Serializer\Type("string")]
    public string $name;

    #[Serializer\Type("integer")]
    public int $type;

    #[Serializer\Type("integer")]
    public int $test1;

    #[Serializer\Type("integer")]
    public int $test2;

    #[Serializer\Type("string")]
    public string $description;

    #[Serializer\Type("string")]
    public string $link;

    #[Serializer\Type("DateTime<'Y-m-d'>")]
    public \DateTimeInterface $date;

    #[Serializer\Type("integer")]
    public int $price;
}