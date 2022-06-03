<?php

namespace App\Dto\Feedback\Request;

use App\Dto\Feedback\FeedbackUserDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\Feedback;

class FeedbackUserRequest extends AbstractRequestDTOTransformer
{
    /**
     * @param FeedbackUserDTO $object
     */
    public function transformToObject($object): Feedback
    {
        $data = new Feedback();
        $data->setEstimation($object->feedbackDTO->estimation);
        $data->setDate($object->feedbackDTO->date);
        $data->setNote($object->feedbackDTO->note);
        return $data;
    }
}