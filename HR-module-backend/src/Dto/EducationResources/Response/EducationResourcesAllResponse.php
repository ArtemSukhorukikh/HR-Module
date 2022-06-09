<?php

namespace App\Dto\EducationResources\Response;

use App\Dto\EducationResources\EducationResourcesAllDTO;
use App\Dto\EducationResources\EducationResourcesCompetenceDTO;
use App\Entity\Competence;
use App\Repository\CompetenceRepository;
use App\Repository\EducationalResourcesRepository;

class EducationResourcesAllResponse
{
    private EducationResourcesListResponse $educationResourcesListResponse;
    private CompetenceRepository $competenceRepository;

    public function __construct(EducationResourcesListResponse $educationResourcesListResponse,
                                CompetenceRepository $competenceRepository)
    {
        $this->educationResourcesListResponse = $educationResourcesListResponse;
        $this->competenceRepository = $competenceRepository;
    }

    public function transformFromObject(): EducationResourcesAllDTO
    {
        $dto = new EducationResourcesAllDTO();
        $competence = $this->competenceRepository->findBy(
            ["includes" => null] );
        $dto->educationResourcesCompetence = $this->educationResourcesListResponse->transformFromObjects($competence);
        return $dto;
    }

}