<?php

namespace App\Dto\EducationResources\Response;

use App\Dto\EducationResources\EducationResourcesListDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\EducationalResources;
use App\Repository\CompetenceRepository;
use App\Repository\EducationalResourcesRepository;

class EducationResourcesUseResponse extends AbstractResponceDTOTransformer
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
     * @param EducationalResources[] $objects
     */
    public function transformFromObject($objects): EducationResourcesListDTO
    {
        $dto = new EducationResourcesListDTO();
        $dto->educationResourcesCompetence = $this->educationResourcesResponse->transformFromObjects($objects);
        return $dto;
    }

}