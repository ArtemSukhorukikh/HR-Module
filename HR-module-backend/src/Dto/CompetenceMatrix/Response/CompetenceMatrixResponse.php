<?php

namespace App\Dto\CompetenceMatrix\Response;

use App\Dto\CompetenceMatrix\CompetenceMatrixDTO;
use App\Dto\CompetenceMatrix\SkillAssessmentDTO;
use App\Dto\Transformer\Response\AbstractResponceDTOTransformer;
use App\Dto\UserDto;
use App\Entity\Department;
use App\Repository\CompetenceRepository;
use App\Repository\SkillAssessmentRepository;
use App\Repository\UserRepository;

class CompetenceMatrixResponse
{
    private CompetenceRepository $competenceRepository;
    private SkillAssessmentRepository $skillAssessmentRepository;
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository,
                                SkillAssessmentRepository $skillAssessmentRepository,
                                CompetenceRepository $competenceRepository)
    {
        $this->userRepository = $userRepository;
        $this->skillAssessmentRepository = $skillAssessmentRepository;
        $this->competenceRepository = $competenceRepository;
    }


    /**
     * @param Department $object
     */
    public function transformFromObject($object): CompetenceMatrixDTO
    {
        $dto = new CompetenceMatrixDTO();
        $users = $this->userRepository->findBy(["works" => $object->getId()]);
        $competence = $object->getMainCompetence();
        $skills = $competence->getSkills();
        $skillAssessments = [];
        foreach ($skills as $skill){
            $skillAssessmentDTO = new SkillAssessmentDTO();
            $skillAssessmentDTO->name = $skill->getName();
            $skillAssessmentUser = [];
            foreach ($users as $user){
                $skillAssessmentUser[] = $this->skillAssessmentRepository->findBy(["skills" => $skill->getId(), "user_" => $user->getId()])[0]->getEstimation();
            }
            $skillAssessmentDTO->skill_assessments = $skillAssessmentUser;
            $dto->skill_assessment[] = $skillAssessmentDTO;
        }
        foreach ($users as $user){
            $userDTO = new UserDto();
            $userDTO->firstname = $user->getFirstName();
            $userDTO->lastname = $user->getLastName();
            $userDTO->rating = $this->userRepository->checkGradeRating($user, $competence);
            $dto->users[] = $userDTO;
        }
        return $dto;
    }

}