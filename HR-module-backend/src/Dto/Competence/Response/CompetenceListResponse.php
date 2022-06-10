<?php

namespace App\Dto\Competence\Response;

use App\Dto\Competence\CompetenceDTO;
use App\Dto\Competence\CompetenceListDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\Competence;


class CompetenceListResponse extends AbstractResponceDTOTransformer
{
    private CompetenceResponse $competenceResponse;

    public function __construct(CompetenceResponse $competenceResponse)
    {
        $this->competenceResponse = $competenceResponse;
    }
    /**
     * @param Competence $object
     */
    public function transformFromObject($object): CompetenceListDTO
    {
        $dto = new CompetenceListDTO();
        $test = $this->transformFromObjects($object);
        $test[] = $this->competenceResponse->transformFromObject($object);
        $dto->competence_dto_s = $test;
        return $dto;
    }

    /**
     * @param Competence $object
     */
    public function transformFromObjects($object): iterable
    {
        if(!is_null($object->getIncludes()))
        {
            $objects = $object->getIncludes();
            $dto = [];
            foreach ($objects as $object_) {

                $dto = $this->transformFromObjects($object_);
                $dto[] = $this->competenceResponse->transformFromObject($object_);
            }
        }
        return $dto;
    }
}