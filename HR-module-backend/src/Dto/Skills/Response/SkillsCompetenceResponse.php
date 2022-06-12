<?php

namespace App\Dto\Skills\Response;

use App\Dto\Skills\SkillsListDTO;
use App\Entity\Competence;
use App\Entity\Department;
use App\Repository\DepartmentRepository;

class SkillsCompetenceResponse
{
    private SkillsResponse $skillsResponse;

    public function __construct(SkillsResponse $skillsResponse)
    {
        $this->skillsResponse = $skillsResponse;
    }
    /**
     * @param Competence $object
     */
    public function transformFromObject($object): SkillsListDTO
    {
        $dto = new SkillsListDTO();
        $skills = $object->getSkills();
        $dto->skills = $this->skillsResponse->transformFromObjects($skills);
        return $dto;
    }
}