<?php

namespace App\Dto\Transformer\Response;

use App\Dto\OfficeDTO;
use App\Dto\OfficesFullDTO;
use App\Entity\Office;
use phpDocumentor\Reflection\Types\Collection;


class OfficesFullResponseDTOTransformer
{
    private OfficeResponseDTOTransformer $officeResponseDTOTransformer;

    public function __construct(OfficeResponseDTOTransformer $officeResponseDTOTransformer)
    {
        $this->officeResponseDTOTransformer = $officeResponseDTOTransformer;
    }

    /**
     * @param Office[] $offices
     */
    public function transformFromObject(array $offices): OfficesFullDTO
    {
        $dto = new OfficesFullDTO();
        $dto->offices = $this->officeResponseDTOTransformer->transformFromObjects($offices);
        return $dto;
    }
}