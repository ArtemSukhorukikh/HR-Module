<?php

namespace App\Dto\Feedback\Request;

use App\Dto\Feedback\FeedbackDeleteDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\Feedback;
use App\Repository\FeedbackRepository;

class FeedbackDeleteRequest extends AbstractRequestDTOTransformer
{
    private FeedbackRepository $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->$feedbackRepository = $feedbackRepository;
    }

    /**
     * @param FeedbackDeleteDTO $object
     */
    public function transformToObject($object): Feedback
    {
        return $this->feedbackRepository->find($object->id);
    }
}