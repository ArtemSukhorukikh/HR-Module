<?php

namespace App\Dto\DevelopmentPlan;

use JMS\Serializer\Annotation as Serializer;

class DevelopmentPlanListDTO
{
    #[Serializer\Type("array<App\Dto\DevelopmentPlan\DevelopmentPlanDTO>")]
    public array $dev_plan;
}