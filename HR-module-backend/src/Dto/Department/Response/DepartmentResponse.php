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
        if ($object->getMainCompetence()){
            $dto->main_competence_id = $object->getMainCompetence()->getId();
            $dto->main_competence_name = $object->getMainCompetence()->getName();
        }
        return $dto;
    }
}