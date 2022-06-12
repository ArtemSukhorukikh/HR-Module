<?php

namespace App\Dto\Skills\Request;

use App\Dto\Skills\SkillsDTO;
use App\Entity\Skills;
use App\Repository\CompetenceRepository;
use App\Repository\DepartmentRepository;

class SkillsRequest
{
    private CompetenceRepository $competenceRepository;

    public function __construct(CompetenceRepository $competenceRepository)
    {
        $this->competenceRepository = $competenceRepository;
    }
    /**
     * @param SkillsDTO $object
     */
    public function transformToObject($object): Skills
    {
        $data = new Skills();
        $data->setName($object->name);
        $data->setDescription($object->description);
        $data->setType(0);
        $data->addCompetence($this->competenceRepository->find($object->competence_id));
        return $data;
    }
}