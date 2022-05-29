<?php

namespace App\Dto\Transformer\Response;

use App\Dto\OfficeDTO;
use App\Entity\Office;


class OfficeResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    private WorkplaceResponseDTOTransformer $workplaceResponseDTOTransformer;

    public function __construct(WorkplaceResponseDTOTransformer $workplaceResponseDTOTransformer)
    {
        $this->workplaceResponseDTOTransformer = $workplaceResponseDTOTransformer;
    }

    /**
     * @param Office $office
     */
    public function transformFromObject($office): OfficeDTO
    {
        $dto = new OfficeDTO();
        $dto->name = $office->getName();
        $dto->floor = $office->getFloor();
        $dto->workplaces = $this->workplaceResponseDTOTransformer->transformFromObjects($office->getWorkplaces());
        return $dto;
    }
}