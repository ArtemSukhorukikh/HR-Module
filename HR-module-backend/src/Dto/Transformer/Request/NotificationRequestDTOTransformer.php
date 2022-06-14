<?php

namespace App\Dto\Transformer\Request;

use App\Dto\EvaluationDTO;
use App\Dto\NotificationDTO;
use App\Entity\Notification;
use App\Entity\TaskEvaluation;
use DateTime;

class NotificationRequestDTOTransformer extends AbstractRequestDTOTransformer
{
    /**
     * @param NotificationDTO $notifaction
     */
    public function transformToObject($notifaction)
    {
        $data = new Notification();
        $data->setText($notifaction->text);
        $data->setDate(new DateTime($notifaction->date));
        return $data;
    }
}