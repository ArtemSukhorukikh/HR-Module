<?php

namespace App\Dto\ResponseSurvey\Request;

use App\Dto\ResponseSurvey\ResponseSurveyDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\ResponeSurvey;
use App\Repository\SurveyRepository;
use App\Repository\UserRepository;

class ResponseSurveyRequest extends AbstractRequestDTOTransformer
{
    private UserRepository $userRepository;
    private SurveyRepository $surveyRepository;

    public function __construct(UserRepository $userRepository, SurveyRepository $surveyRepository)
    {
        $this->userRepository = $userRepository;
        $this->surveyRepository = $surveyRepository;
    }
    /**
     * @param ResponseSurveyDTO $object
     */
    public function transformToObject($object)
    {
        $data = new ResponeSurvey();
        $data->setAnswer($object->answer);
        $data->setSurvey($this->surveyRepository->find($object->surveyId));
        $data->setUser($this->userRepository->find($object->userId));
        return $data;
    }
}