<?php

namespace App\Dto\Department\Response;

use App\Dto\Department\DepartmentDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\Department;

class DepartmentResponse extends AbstractResponceDTOTransformer
{
    /**
     * @param Department $object
     */
    public function transformFromObject($object): DepartmentDTO
    {
        $dto = new DepartmentDTO();
        $dto->id = $object->getId();
        $dto->name = $object->getName();
        $dto->main_competence_id = $object->getMainCompetence()->getId();
        $dto->main_competence_name = $object->getMainCompetence()->getName();
        $dto->obeys_id = $object->getObeys()->getId();
        $dto->obeys_name = $object->getObeys()->getName();
        $dto->dep_id = $object->getDepartment()->getId();
        $dto->dep_name = $object->getDepartment()->getName();
        $dto->director_id = $object->getDirector()->getId();
        $dto->director_name = $object->getDirector()->getFirstName().' '.$object->getDirector()->getLastName();
        return $dto;
    }
}