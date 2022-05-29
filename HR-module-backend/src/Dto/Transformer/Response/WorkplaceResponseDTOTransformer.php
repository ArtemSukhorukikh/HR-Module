<?php

namespace App\Dto\Transformer\Response;

use App\Dto\AnswearDTO;
use App\Dto\WorkplaceDTO;
use App\Entity\Workplace;


class WorkplaceResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    private UserResponseDTOTransformer $userResponseDTOTransformer;

    public function __construct(UserResponseDTOTransformer $userResponseDTOTransformer)
    {
        $this->userResponseDTOTransformer = $userResponseDTOTransformer;
    }

    /**
     * @param Workplace $workplace
     */
    public function transformFromObject($workplace): WorkplaceDTO
    {
        $dto = new WorkplaceDTO();
        $dto->RoomInTheOffice = $workplace->getRoomInTheOffice();
        $dto->user = $this->userResponseDTOTransformer->transformFromObject($workplace->getUserInWorkplace());
        return $dto;
    }
}