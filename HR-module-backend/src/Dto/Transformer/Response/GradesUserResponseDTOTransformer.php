<?php

namespace App\Dto\Transformer\Response;

use App\Dto\GradesUserDTO;
use App\Dto\OfficeDTO;
use App\Dto\OfficesFullDTO;
use App\Entity\Grade;
use App\Entity\Office;
use phpDocumentor\Reflection\Types\Collection;


class GradesUserResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    private GradeResponseDTOTransformer $gradeResponseDTOTransformer;

    public function __construct(GradeResponseDTOTransformer $gradeResponseDTOTransformer)
    {
        $this->gradeResponseDTOTransformer = $gradeResponseDTOTransformer;
    }

    /**
     * @param Grade[] $grades
     */
    public function transformFromObject($grades): GradesUserDTO
    {
        $dto = new GradesUserDTO();
        $dto->grades = $this->gradeResponseDTOTransformer->transformFromObjects($grades);
        return $dto;
    }
}