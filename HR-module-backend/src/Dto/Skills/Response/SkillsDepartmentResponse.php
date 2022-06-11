<?php

namespace App\Dto\Skills\Response;

use App\Dto\Skills\SkillsListDTO;
use App\Entity\Department;
use App\Repository\DepartmentRepository;

class SkillsDepartmentResponse
{
    private SkillsResponse $skillsResponse;

    public function __construct(SkillsResponse $skillsResponse)
    {
        $this->skillsResponse = $skillsResponse;
    }
    /**
     * @param Department $object
     */
    public function transformFromObject($object): SkillsListDTO
    {
        $dto = new SkillsListDTO();
        $skills = $object->getMainCompetence()->getSkills();
        $dto->skills = $this->skillsResponse->transformFromObjects($skills);
        return $dto;
    }
}