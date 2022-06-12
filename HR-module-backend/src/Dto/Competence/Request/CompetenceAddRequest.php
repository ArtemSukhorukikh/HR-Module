<?php

namespace App\Dto\Competence\Request;

use App\Dto\Competence\CompetenceDTO;
use App\Dto\Feedback\FeedbackDTO;
use App\Dto\Transformer\Request\AbstractRequestDTOTransformer;
use App\Entity\Competence;
use App\Entity\Feedback;
use App\Repository\CompetenceRepository;
use App\Repository\EducationalResourcesRepository;
use App\Repository\SkillsRepository;
use App\Repository\UserRepository;

class CompetenceAddRequest extends AbstractRequestDTOTransformer
{

    private CompetenceRepository $competenceRepository;
    private EducationalResourcesRepository $educationalResourcesRepository;
    private UserRepository $userRepository;
    private SkillsRepository $skillsRepository;

    public function __construct(
        CompetenceRepository $competenceRepository,
        UserRepository $userRepository,
        SkillsRepository $skillsRepository,
        EducationalResourcesRepository $educationalResourcesRepository)
    {
        $this->competenceRepository = $competenceRepository;
        $this->educationalResourcesRepository = $educationalResourcesRepository;
        $this->userRepository = $userRepository;
        $this->skillsRepository = $skillsRepository;
    }
    /**
     * @param CompetenceDTO $object
     */
    public function transformToObject($object): Competence
    {
        $data = new Competence();
        $data->setType($object->type);
        $data->setDescription($object->description);
        $data->setName($object->name);
        $data->setNeedRating($object->need_rating);
        return $data;
    }
}