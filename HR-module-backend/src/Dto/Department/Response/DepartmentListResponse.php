<?php

namespace App\Dto\Department\Response;

use App\Dto\Department\DepartmentDTO;
use App\Dto\Department\DepartmentListDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\Department;

class DepartmentListResponse extends AbstractResponceDTOTransformer
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
        $dto->id = $object->getId();
        $dto->name = $object->getName();
        $dto->director_name = 'Нет главы отдела';
        if ($object->getDirector()){
            $dto->director_name = $object->getDirector()->getFirstName().' '.$object->getDirector()->getLastName();
        }
        if (count($object->getDepartments())){
            $dto->children = $this->rec($object)->children;
        }
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
            $dto_->id = $dep->getId();
            $dto_->name = $dep->getName();
            if ($dep->getDirector()){
                $dto->director_name = $dep->getDirector()->getFirstName().' '.$dep->getDirector()->getLastName();
            } else  {
                $dto_->director_name = 'Нет главы отдела';
            }
            $dto->children[] = $dto_;
        }
        return $dto;
    }
}