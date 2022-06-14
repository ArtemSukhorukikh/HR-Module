<?php

namespace App\Dto\Transformer\Response;

use App\Dto\EvaluationDTO;
use App\Dto\NotificationDTO;
use App\Entity\Notification;
use App\Entity\TaskEvaluation;


class NotificationResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    /**
     * @param Notification $n
     */
    public function transformFromObject($n): NotificationDTO
    {
        $dto = new NotificationDTO();
        $dto->id = $n->getId();
        $dto->text = $n->getText();
        $dto->date = $n->getDate()->format("Y-m-d H-m");
        return $dto;
    }
}