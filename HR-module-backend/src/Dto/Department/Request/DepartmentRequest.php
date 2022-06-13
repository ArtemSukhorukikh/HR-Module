<?php

namespace App\Dto\Department\Request;

use App\Dto\Competence\CompetenceDTO;
use App\Dto\Department\DepartmentDTO;
use App\Entity\Department;

class DepartmentRequest
{
    /**
     * @param DepartmentDTO $object
     */
    public function transformToObject($object): Department
    {
        $data = new Department();
        $data->setName($object->name);
        return $data;
    }
}