<?php

namespace App\Controller;

use App\Dto\SkillAssessment\Request\SkillAssessmentRequest;
use App\Dto\SkillAssessment\SkillAssessmentDTO;
use App\Entity\SkillAssessment;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use JMS\Serializer\SerializerBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class SkillAssessmentController extends AbstractController
{
    private  SkillAssessmentRequest $skillAssessmentRequest;
    private $serializer;

    public function __construct(SkillAssessmentRequest $skillAssessmentRequest,)
    {
        $this->serializer = SerializerBuilder::create()->build();
        $this->skillAssessmentRequest = $skillAssessmentRequest;
    }
    #[Route('/skillAssessment/new', name: 'app_skill_assessment')]
    public function newSkillAssessment(Request $request, ManagerRegistry  $doctrine): Response
    {
        $data = $this->serializer->deserialize($request->getContent(), SkillAssessmentDTO::class, 'json');
        $skillAssessment = $this->skillAssessmentRequest->transformToObject($data);
        $entityManager = $doctrine->getManager();
        $skillAssessment_ = $entityManager->getRepository(SkillAssessment::class)->findOneBy(["user_" => $skillAssessment->getUser()->getId(), "skills" => $skillAssessment->getSkills()->getId()]);
        $skillAssessment_->setEstimation($skillAssessment->getEstimation());
        $skillAssessment_->setDate($skillAssessment->getDate());
        $entityManager->flush();

        return $this->json($data, Response::HTTP_CREATED);
    }
}
