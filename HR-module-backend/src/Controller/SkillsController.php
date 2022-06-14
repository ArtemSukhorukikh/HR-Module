<?php

namespace App\Controller;

use App\Dto\AnswearDTO;
use App\Dto\Skills\Request\SkillsRequest;
use App\Dto\Skills\Response\SkillsCompetenceResponse;
use App\Dto\Skills\Response\SkillsDepartmentResponse;
use App\Dto\Skills\Response\SkillsResponse;
use App\Dto\Skills\SkillsDTO;
use App\Entity\SkillAssessment;
use App\Entity\Skills;
use App\Entity\User;
use App\Repository\CompetenceRepository;
use App\Repository\DepartmentRepository;
use App\Repository\SkillsRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/')]
class SkillsController extends AbstractController
{
    private SkillsDepartmentResponse $skillsDepartmentResponse;
    private SkillsResponse $skillsResponse;
    private SkillsCompetenceResponse $skillsCompetenceResponse;
    private SkillsRequest $skillsRequest;
    private $serializer;

    public function __construct(SkillsDepartmentResponse $skillsDepartmentResponse,
                                SkillsCompetenceResponse $skillsCompetenceResponse,
                                SkillsResponse $skillsResponse,
                                SkillsRequest $skillsRequest)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->skillsDepartmentResponse = $skillsDepartmentResponse;
        $this->skillsResponse = $skillsResponse;
        $this->skillsCompetenceResponse = $skillsCompetenceResponse;
        $this->skillsRequest = $skillsRequest;
    }

    #[Route('skills/{id}', name: 'app_skills_find', methods: "GET")]
    public function findSkill($id, SkillsRepository $skillsRepository): Response
    {
        $skills = $skillsRepository->find($id);
        $skillsDTO = $this->skillsResponse->transformFromObject($skills);
        return $this->json($skillsDTO, Response::HTTP_OK);
    }

    #[Route('skills/department/{id}', name: 'app_skills_department', methods: "GET")]
    public function findSkillsDepartment($id, DepartmentRepository $departmentRepository, UserRepository $userRepository): Response
    {
        $department = $userRepository->find($id)->getWorks();
        $skillsDTO = $this->skillsDepartmentResponse->transformFromObject($department);
        return $this->json($skillsDTO, Response::HTTP_OK);
    }

    #[Route('skills/competence/{id}', name: 'app_skills_competence', methods: "GET")]
    public function findSkills($id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);
        $competence = $user->getWorks()->getMainCompetence();
        $skillsDTO = $this->skillsCompetenceResponse->transformFromObject($competence);
        return $this->json($skillsDTO, Response::HTTP_OK);
    }

    #[Route('skills/new/{id}', name: 'app_skills_new', methods: "POST")]
    public function newSkill($id, Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager, ManagerRegistry  $doctrine): Response
    {
        $user_ = $userRepository->find($id);
        $competence = $user_->getWorks()->getMainCompetence();
        $data = $this->serializer->deserialize($request->getContent(), SkillsDTO::class, 'json');
        $skill = $this->skillsRequest->transformToObject($data);
        $skill->addCompetence($competence);
        $entityManager->persist($skill);
        $entityManager->flush();

        $entityManager_ = $doctrine->getManager();
        $users = $skill->getCompetence()[0]->getUsers();
        var_dump($skill->getCompetence()[0]->getUsers()[0]->getId());
        foreach ($users as $user){
            $skillAs = new SkillAssessment();
            $skillAs->setSkills($skill);
            $skillAs->setUser($user);
            $skillAs->setEstimation(0);
            $date = new DateTime;
            $skillAs->setDate($date);
            $entityManager_->persist($skillAs);
            $entityManager_->flush();
        }

        return $this->json($data, Response::HTTP_CREATED);
    }

    #[Route('skills/change/{id}', name: 'app_skills_change', methods: "POST")]
    public function changeSkill($id, Request $request, CompetenceRepository $competenceRepository, ManagerRegistry  $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $skill = $entityManager->getRepository(Skills::class)->find($id);

        $data = $this->serializer->deserialize($request->getContent(), SkillsDTO::class, 'json');
        $skill_ = $this->skillsRequest->transformToObject($data);

        $skill->setDescription($skill_->getDescription());
        $skill->setName($skill_->getName());
        $entityManager->flush();
        $answer = new AnswearDTO();
        $answer->status = 'Changed';
        $answer->messageAnswear = "Changed " . $id;
        return $this->json($answer, Response::HTTP_OK);
    }

    #[Route('skills/delete/{id}', name: 'app_skills_remove', methods: "POST")]
    public function removeSkills($id, Request $request, ManagerRegistry  $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $skill = $entityManager->getRepository(Skills::class)->find($id);
        if ($skill) {
            $entityManager->remove($skill);
            $entityManager->flush();
            $answer = new AnswearDTO();
            $answer->status = 'Deleted';
            $answer->messageAnswear = "Deleted " . $id;
            return $this->json($answer, Response::HTTP_OK);

            //return $this->json(Response::HTTP_OK);
        }
        $answer = new AnswearDTO();
        $answer->status = 'Error delete';
        $answer->messageAnswear = "Un  deleted " . $id;
        return $this->json($answer, Response::HTTP_BAD_REQUEST);
    }
}
