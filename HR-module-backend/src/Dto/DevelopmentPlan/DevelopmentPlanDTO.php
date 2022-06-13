<?php

namespace App\Dto\DevelopmentPlan;

use JMS\Serializer\Annotation as Serializer;

class DevelopmentPlanDTO
{
    #[Serializer\Type("string")]
    public string $name;

    #[Serializer\Type("string")]
    public string $position;

    #[Serializer\Type("DateTime<'Y-m-d'>")]
    public \DateTimeInterface $start_date;

    #[Serializer\Type("DateTime<'Y-m-d'>")]
    public \DateTimeInterface $end_date;

    #[Serializer\Type("string")]
    public string $type;

    #[Serializer\Type("string")]
    public string $comp_name;

    #[Serializer\Type("string")]
    public string $res_name;

}