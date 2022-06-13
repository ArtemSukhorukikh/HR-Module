<?php

namespace App\Dto\Department\Response;

use App\Dto\Department\DepartmentListDTO;
use App\Entity\Department;

class DepartmentListResponse
{
    private DepartmentResponse $departmentResponse;

    public function __construct(DepartmentResponse $departmentResponse)
    {
        $this->departmentResponse = $departmentResponse;
    }

    /**
     * @param Department[] $objects
     */
    public function transformFromObject($objects): DepartmentListDTO
    {
        $dto = new DepartmentListDTO();
        $dto->departsments = $this->departmentResponse->transformFromObjects($objects);
        return $dto;
    }
}