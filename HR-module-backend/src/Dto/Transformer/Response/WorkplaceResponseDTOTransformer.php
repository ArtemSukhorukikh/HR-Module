<?php

namespace App\Dto\Transformer\Response;

use App\Dto\AnswearDTO;
use App\Dto\WorkplaceDTO;
use App\Entity\Workplace;


class WorkplaceResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    private UserOfficeResponseDTOTransformer $userResponseDTOTransformer;

    public function __construct(UserOfficeResponseDTOTransformer $userResponseDTOTransformer)
    {
        $this->userResponseDTOTransformer = $userResponseDTOTransformer;
    }

    /**
     * @param Workplace $workplace
     */
    public function transformFromObject($workplace): WorkplaceDTO
    {
        $dto = new WorkplaceDTO();
        $dto->id = $workplace->getId();
        $dto->RoomInTheOffice = $workplace->getRoomInTheOffice();
        $user = $workplace->getUserInWorkplace();
        if ($user){
            $dto->user = $this->userResponseDTOTransformer->transformFromObject($workplace->getUserInWorkplace());
        }
        return $dto;
    }
}