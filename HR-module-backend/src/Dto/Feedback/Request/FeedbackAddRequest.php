<?php

namespace App\Dto\Feedback\Request;

use App\Dto\Feedback\FeedbackDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\Feedback;
use App\Repository\FeedbackRepository;

class FeedbackAddRequest extends AbstractRequestDTOTransformer
{
    private FeedbackRepository $feedbackRepository;

    public function __construct(FeedbackRepository $feedbackRepository)
    {
        $this->feedbackRepository = $feedbackRepository;
    }
    /**
     * @param FeedbackDTO $object
     */
    public function transformToObject($object): Feedback
    {
        $data = new Feedback();
        //$data->setAuthon($object->user_id);
        //$data->setEducationalResources($object->educationalResourcesId);
        $data->setEstimation($object->estimation);
        $data->setDate($object->date);
        $data->setNote($object->note);
        return $data;
    }
}