<?php

namespace App\Dto\Competence\Response;

use App\Dto\Competence\CompetenceDTO;
use App\Dto\Competence\CompetenceListDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\Competence;


class CompetenceAllResponse extends AbstractResponceDTOTransformer
{
    private CompetenceResponse $competenceResponse;

    public function __construct(CompetenceResponse $competenceResponse)
    {
        $this->competenceResponse = $competenceResponse;
    }
    /**
     * @param Competence[] $objects
     */
    public function transformFromObject($objects): CompetenceListDTO
    {
        $dto = new CompetenceListDTO();
        $dto->competence_dto_s = $this->competenceResponse->transformFromObjects($objects);
        return $dto;
    }
}