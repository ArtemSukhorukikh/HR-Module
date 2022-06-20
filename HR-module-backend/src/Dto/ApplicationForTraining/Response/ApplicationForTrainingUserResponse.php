<?php

namespace App\Dto\ApplicationForTraining\Response;

use App\Dto\ApplicationForTraining\ApplicationForTrainingAnswer;
use App\Dto\ApplicationForTraining\ApplicationForTrainingDTO;
use App\Dto\ApplicationForTraining\ApplicationForTrainingListDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Entity\ApplicationForTraining;
use App\Entity\User;
use App\Repository\ApplicationForTrainingRepository;

class ApplicationForTrainingUserResponse extends AbstractResponceDTOTransformer
{
    private ApplicationForTrainingRepository $applicationForTrainingRepository;

    public function __construct(ApplicationForTrainingRepository $applicationForTrainingRepository)
    {
        $this->applicationForTrainingRepository = $applicationForTrainingRepository;
    }
    /**
     * @param User $object
     */
    public function transformFromObject($object): ?ApplicationForTrainingListDTO
    {
        $dto = new ApplicationForTrainingListDTO();
        $application = $this->applicationForTrainingRepository->findBy(
            ["compose" => $object->getId()]
        );
        if ($application == null)
        {
            return null;
        }
        $dto->applicationForTrainingDTO = [];
        foreach ($application as $app)
        {
            $dto_ = new ApplicationForTrainingDTO();
            $dto_->id = $app->getId();
            $dto_->user_name = $object->getFirstName() . ' ' . $object->getLastName();
            $dto_->ed_name = $app->getIncluded()->getName();
            $dto_->user_id = $app->getCompose()->getId();
            $dto_->ed_res_id = $app->getIncluded()->getId();
            $dto_->start_date = $app->getStartDate();
            $dto_->end_date = $app->getEndDate();
            $dto_->method_of_passage = $app->getMathodOfPassage();
            $dto_->note = $app->getNote();
            $dto_->status = $app->getStatus();
            if ($app->getResponseToRequest()){
                $dtoAnswer = new ApplicationForTrainingAnswer();
                $dtoAnswer->id = $app->getResponseToRequest()->getId();
                $dtoAnswer->login = $app->getResponseToRequest()->getLogin();
                $dtoAnswer->password = $app->getResponseToRequest()->getPassword();
                $dto_->application_answer = $dtoAnswer;
            }
            array_push($dto->applicationForTrainingDTO, $dto_);
        }
        return $dto;
    }
}