<?php

namespace App\Dto\Feedback\Request;

use App\Dto\Feedback\FeedbackUpdateDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\Feedback;
use App\Repository\FeedbackRepository;

class FeedbackUpdateRequest extends AbstractRequestDTOTransformer
{
    private FeedbackRepository $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }

    /**
     * @param FeedbackUpdateDTO $object
     */
    public function transformToObject($object): Feedback
    {
        $data = $this->feedbackRepository->find($object->id);
        $data->setEstimation($object->estimation);
        $data->setDate($object->date);
        $data->setNote($object->note);
        return $data;
    }

}