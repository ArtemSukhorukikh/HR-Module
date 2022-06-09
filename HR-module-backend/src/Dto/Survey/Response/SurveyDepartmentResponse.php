<?php

namespace App\Dto\Survey\Response;

use App\Dto\Survey\SurveyListDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\User;
use App\Repository\SurveyRepository;

class SurveyDepartmentResponse extends AbstractResponceDTOTransformer
{

    private SurveyRepository $surveyRepository;
    private SurveyResponse $surveyResponse;

    public function __construct(SurveyResponse $surveyResponse,
                                SurveyRepository $surveyRepository)
    {
        $this->surveyResponse = $surveyResponse;
        $this->surveyRepository = $surveyRepository;
    }
    /**
     * @param User $object
     */
    public function transformFromObject($object):SurveyListDTO
    {
        $dto = new SurveyListDTO();
        $listSurvey = $this->surveyRepository->findBy(["department" => $object->getWorks()]);
        $dto->surveyListDTO = $this->surveyResponse->transformFromObjects($listSurvey);
        return $dto;
    }
}