<?php

namespace App\Dto\Feedback\Request;

use App\Dto\Feedback\FeedbackDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\Feedback;

class FeedbackRequest extends AbstractRequestDTOTransformer
{
    /**
     * @param FeedbackDTO $feedback
     */
    public function transformToObject($feedback)
    {
        $data = new Feedback();
        $data->setEstimation((integer)$feedback->estimation);
        $data->setDate($feedback->date);
        $data->setNote((string)$feedback->note);
        return $data;
    }
}