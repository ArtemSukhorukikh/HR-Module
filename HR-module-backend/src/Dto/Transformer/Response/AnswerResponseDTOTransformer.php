<?php

namespace App\Dto\Transformer\Response;

use App\Dto\AnswearDTO;


class AnswerResponseDTOTransformer
{
    /**
     * @param string $status
     * @param string $message
     */
    public function transformFromObject($status, $message): AnswearDTO
    {
        $dto = new AnswearDTO();
        $dto->status = $status;
        $dto->messageAnswear = $message();
        return $dto;
    }
}