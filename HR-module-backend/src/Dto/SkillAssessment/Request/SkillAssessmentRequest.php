<?php

namespace App\Dto\SkillAssessment\Request;

use App\Dto\SkillAssessment\SkillAssessmentDTO;
use App\Entity\SkillAssessment;
use App\Repository\SkillsRepository;
use App\Repository\UserRepository;
use DateTime;

class SkillAssessmentRequest
{
    private UserRepository $userRepository;
    private SkillsRepository $skillsRepository;

    public function __construct(
        UserRepository $userRepository,
        SkillsRepository $skillsRepository)
    {
        $this->userRepository = $userRepository;
        $this->skillsRepository = $skillsRepository;
    }
    /**
     * @param SkillAssessmentDTO $object
     */
    public function transformToObject($object): SkillAssessment
    {
        $data = new SkillAssessment();
        $data->setUser($this->userRepository->find($object->user_id));
        $data->setSkills($this->skillsRepository->find($object->skills_id));
        $data->setEstimation($object->estimation);
        $date = new DateTime();
        $data->setDate($date);
        return $data;
    }
}