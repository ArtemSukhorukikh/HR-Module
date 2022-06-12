<?php

namespace App\Dto\EducationResources\Response;

use App\Dto\EducationResources\EducationResourcesAllDTO;
use App\Dto\EducationResources\EducationResourcesCompetenceDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\Competence;
use App\Repository\CompetenceRepository;
use App\Repository\EducationalResourcesRepository;

class EducationResourcesCompetenceResponse extends AbstractResponceDTOTransformer
{
    private EducationResourcesResponse $educationResourcesResponse;
    private EducationalResourcesRepository $educationalResourcesRepository;
    private CompetenceRepository $competenceRepository;

    public function __construct(EducationResourcesResponse $educationResourcesResponse,
                                EducationalResourcesRepository $educationalResourcesRepository,
                                CompetenceRepository $competenceRepository)
    {
        $this->educationResourcesResponse = $educationResourcesResponse;
        $this->educationalResourcesRepository = $educationalResourcesRepository;
        $this->competenceRepository = $competenceRepository;
    }
    /**
     * @param Competence $object
     */
    public function transformFromObject($object): EducationResourcesCompetenceDTO
    {
        $dto = new EducationResourcesCompetenceDTO();
        $educationalResources = $object->getEducationalResources();
        $dto->id = $object->getId();
        $dto->competence = $object->getName();
        $dto->educationResourcesCompetence = $this->educationResourcesResponse->transformFromObjects($educationalResources);
        return $dto;
    }
}