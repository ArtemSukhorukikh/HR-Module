<?php

namespace App\Dto\EducationResources\Request;

use App\Dto\EducationResources\EducationResourcesDTO;
use App\Dto\EducationResources\Response\EducationResourcesResponse;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\EducationalResources;
use App\Repository\CompetenceRepository;
use App\Repository\EducationalResourcesRepository;
use DateTime;

class EducationResourcesRequest extends AbstractRequestDTOTransformer
{
    private EducationalResourcesRepository $educationalResourcesRepository;
    private CompetenceRepository $competenceRepository;

    public function __construct(EducationalResourcesRepository $educationalResourcesRepository,
                                CompetenceRepository $competenceRepository)
    {
        $this->educationalResourcesRepository = $educationalResourcesRepository;
        $this->competenceRepository = $competenceRepository;
    }
    /**
     * @param EducationResourcesDTO $object
     */
    public function transformToObject($object): EducationalResources
    {
        $data = new EducationalResources();
        $data->setName($object->name);
        $data->setLink($object->link);
        $data->setDescription($object->description);
        $date = new DateTime();
        $data->setDate($date);
        $data->setPrice($object->price);
        $data->setType($object->type);
        return $data;
    }
}