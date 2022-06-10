<?php

namespace App\Dto\Feedback\Request;

use App\Dto\Feedback\FeedbackDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\Feedback;
use App\Repository\EducationalResourcesRepository;
use App\Repository\UserRepository;

class FeedbackRequest extends AbstractRequestDTOTransformer
{

    private UserRepository $userRepository;
    private EducationalResourcesRepository $educationalResourcesRepository;

    public function __construct(
        UserRepository $userRepository,
        EducationalResourcesRepository $educationalResourcesRepository)
    {
        $this->userRepository = $userRepository;
        $this->educationalResourcesRepository = $educationalResourcesRepository;
    }
    /**
     * @param FeedbackDTO $feedback
     */
    public function transformToObject($feedback): Feedback
    {
        $data = new Feedback();
        $data->setAuthon($this->userRepository->find($feedback->userId));
        $data->setEducationalResources($this->educationalResourcesRepository->find($feedback->educationalResourcesId));
        $data->setEstimation((integer)$feedback->estimation);
        $data->setDate($feedback->date);
        $data->setNote((string)$feedback->note);
        return $data;
    }
}