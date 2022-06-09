<?php

namespace App\Dto\EducationResources\Response;

use App\Dto\EducationResources\EducationResourcesAllDTO;
use App\Dto\EducationResources\EducationResourcesCompetenceDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\Competence;
use App\Entity\EducationalResources;
use App\Repository\CompetenceRepository;
use App\Repository\EducationalResourcesRepository;

class EducationResourcesAllResponse extends AbstractResponceDTOTransformer
{
    private EducationResourcesListResponse $educationResourcesListResponse;

    public function __construct(EducationResourcesListResponse $educationResourcesListResponse,
                                CompetenceRepository $competenceRepository)
    {
        $this->educationResourcesListResponse = $educationResourcesListResponse;
    }

    /**
     * @param Competence[] $objects
     */
    public function transformFromObject($objects): EducationResourcesAllDTO
    {
        $dto = new EducationResourcesAllDTO();
        $dto->educationResourcesAll = $this->educationResourcesListResponse->transformFromObjects($objects);
        return $dto;
    }

}