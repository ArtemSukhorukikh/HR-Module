<?php

namespace App\Dto\ResponseSurvey\Response;

use App\Dto\ResponseSurvey\ResponseSurveyListDTO;
use App\Entity\ResponeSurvey;
use App\Entity\Survey;
use App\Repository\ResponeSurveyRepository;

class ResponseSurveyListResponse
{
    private ResponeSurveyRepository $responeSurveyRepository;
    private ResponseSurveyResponse $responseSurveyResponse;

    public function __construct(ResponeSurveyRepository $responeSurveyRepository,
                                ResponseSurveyResponse $responseSurveyResponse)
    {
        $this->responeSurveyRepository = $responeSurveyRepository;
        $this->responseSurveyResponse = $responseSurveyResponse;
    }
    /**
     * @param Survey $object
     */
    public function transformToObject($object)
    {
        $data = new ResponseSurveyListDTO();
        $listResponceSurvey = $this->responeSurveyRepository->findBy(["survey" => $object]);
        $data->responseSurveyAll = $this->responseSurveyResponse->transformFromObjects($listResponceSurvey);
        return $data;
    }
}