<?php

namespace App\Controller;

use App\Dto\AnswearDTO;
use App\Dto\Transformer\Response\ProjectAndTasksResponseDTOTransformer;
use App\Dto\Transformer\Response\ProjectsResponseDTOTransformer;

use App\Dto\Transformer\Response\TasksResponseDTOTransformer;
use App\Entity\Projects;
use App\Repository\ProjectsRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;
use Redmine\Client\NativeCurlClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Redmine\Exception;

#[Route('/api/v1')]
class ProjectsController extends AbstractController
{
    public NativeCurlClient $client;
    public ProjectsResponseDTOTransformer $projectsResponseDTOTransformer;
    public ProjectAndTasksResponseDTOTransformer $projectAndTasksResponseDTOTransformer;
    public function __construct(ProjectsResponseDTOTransformer $projectsResponseDTOTransformer,
    ProjectAndTasksResponseDTOTransformer $projectAndTasksResponseDTOTransformer)
    {
        $this->client = new NativeCurlClient("http://192.168.0.16:3000", "0fb32ce4b235496fb8cb386cd6e7a0dfefa2e2df");
        $this->projectsResponseDTOTransformer = $projectsResponseDTOTransformer;
        $this->projectAndTasksResponseDTOTransformer = $projectAndTasksResponseDTOTransformer;
    }

    #[Route('/sync/projects', name: 'app_projects_sync', methods: "GET")]
    public function syncProjects(ProjectsRepository $projectsRepository, EntityManagerInterface $entityManager): Response
    {
        $projects = $this->client->getApi('project')->all();
        foreach ($projects['projects'] as $project) {
            if (!$projectsRepository->find($project['id'])) {
                $projectHR = new Projects();
            }
            else {
                $projectHR = $projectsRepository->find($project['id']);
            }
            $projectHR->setId($project['id']);
            $projectHR->setDescription($project['description']);
            $projectHR->setName($project['name']);
            $projectHR->setStatus($project['status']);
            $timeStart = mb_substr($project['created_on'],0,10);
            $timeStart = DateTime::createFromFormat("Y-m-d", $timeStart);
            $projectHR->setCreatedOn($timeStart);
            $entityManager->persist($projectHR);
            $entityManager->flush();
        }
        $answer = new AnswearDTO();
        $answer->status = 'Sync';
        $answer->messageAnswear = "Sync " . $projects['total_count'];
        return $this->json($answer, Response::HTTP_OK);
    }

    #[Route('/projects', name: 'app_projects', methods: "GET")]
    public function getProjects(ProjectsRepository $projectsRepository): Response
    {
        return $this->json($this->projectsResponseDTOTransformer->transformFromObjects($projectsRepository->findAll()));
    }

    #[Route('/project/{id}', name: 'app_project', methods: "GET")]
    public function getProject(int $id, ProjectsRepository $projectsRepository): Response
    {
        $project = $projectsRepository->find($id);
        if ($project) {
            return $this->json($this->projectAndTasksResponseDTOTransformer->transformFromObject($projectsRepository->find($id)));
        } else {
            $answer = new AnswearDTO();
            $answer->status = 'Project doesnt find';
            $answer->messageAnswear = "404 Eror";
            return $this->json($answer, Response::HTTP_NOT_FOUND);
        }

    }
}
