<?php

namespace App\Dto\Department\Response;

use App\Dto\Department\DepartmentDTO;
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
     * @param Department $object
     */
    public function transformFromObject($object): DepartmentDTO
    {
        $dto = new DepartmentDTO();
        $dto->name = $object->getName();
        $dto->director_name = 'Нет главы отдела';
        if ($object->getDirector()){
            $dto->director_name = $object->getDirector()->getLastName().' '.$object->getDirector()->getLastName();
        }
        $dto->children = $this->rec($object)->children;
        return $dto;
    }

    public function rec(Department $object): ?DepartmentDTO
    {
        $dto = new DepartmentDTO();
        foreach ($object->getDepartments() as $dep){
            $dto_ = new DepartmentDTO();
            if (count($dep->getDepartments()) > 0){
                $req = $this->rec($dep);
                $dto_->children = $req->children;
            }
            $dto_->name = $dep->getName();
            if ($dep->getDirector()){
                $dto->director_name = $dep->getDirector()->getLastName().' '.$dep->getDirector()->getLastName();
            } else  {
                $dto_->director_name = 'Нет главы отдела';
            }
            $dto->children[] = $dto_;
        }
        return $dto;
    }
}