<?php

namespace App\Dto\EducationResources\Response;

use App\Dto\EducationResources\EducationResourcesCompetenceDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\Competence;
use App\Repository\EducationalResourcesRepository;

class EducationResourcesListResponse extends AbstractResponceDTOTransformer
{
    private EducationResourcesResponse $educationResourcesResponse;
    private EducationalResourcesRepository $educationalResourcesRepository;

    public function __construct(EducationResourcesResponse $educationResourcesResponse,
                                EducationalResourcesRepository $educationalResourcesRepository)
    {
        $this->educationResourcesResponse = $educationResourcesResponse;
        $this->educationalResourcesRepository = $educationalResourcesRepository;
    }
    /**
     * @param Competence $object
     */
    public function transformFromObject($object): EducationResourcesCompetenceDTO
    {
        $dto = new EducationResourcesCompetenceDTO();
        $educationalResources = $this->educationalResourcesRepository->findBy(
            ["competences" => $object] );
        $dto->competence = $object->getName();
        $dto->educationResourcesCompetence = $this->educationResourcesResponse->transformFromObjects($educationalResources);
        return $dto;
    }
}