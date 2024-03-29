<?php

namespace App\Controller;

use App\Dto\AnswearDTO;
use App\Dto\Transformer\Response\TasksResponseDTOTransformer;
use App\Entity\Task;
use App\Entity\TimeEntries;
use App\Repository\ProjectsRepository;
use App\Repository\TaskRepository;
use App\Repository\TimeEntriesRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Redmine\Client\NativeCurlClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1')]
class TasksController extends AbstractController
{
    public NativeCurlClient $client;
    public TasksResponseDTOTransformer $tasksResponseDTOTransformer;
    public function __construct(TasksResponseDTOTransformer $tasksResponseDTOTransformer)
    {
        $this->client = new NativeCurlClient($_ENV['REDMINE_ADRESS'], $_ENV['REDMINE_TOKEN']);
        $this->tasksResponseDTOTransformer = $tasksResponseDTOTransformer;

    }

    #[Route('/sync/tasks', name: 'app_tasks_sync', methods: "GET")]
    public function syncTasks(ProjectsRepository $projectsRepository,
                          UserRepository $userRepository,
                          EntityManagerInterface $entityManager,
                          TimeEntriesRepository $timeEntriesRepository,
                          TaskRepository $taskRepository): Response
    {
        $tasks = $this->client->getApi('issue')->all();
        foreach ($tasks['issues'] as $task) {
            if (!$taskRepository->find($task['id'])) {
                $taskHR = new Task();
                $taskHR->setId($task['id']);
            }
            else{
                $taskHR = $taskRepository->find($task['id']);
            }
            $taskHR->setName($task['subject']);
            $taskHR->setDescription($task['description']);
            $taskHR->setStatus($task['status']['name']);
            $timeStart = mb_substr($task['start_date'],0,10);
            $timeStart = DateTime::createFromFormat("Y-m-d", $timeStart);
            $taskHR->setStartDate($timeStart);
            if ($task['estimated_hours'] != null) {
                $taskHR->setEstimatedHours($task['estimated_hours']);
            }
            else {
                $taskHR->setEstimatedHours(0);
            }
            if (array_key_exists('assigned_to', $task)) {
                $userAssigned = $this->client->getApi('user')->show($task['assigned_to']['id']);
                if (array_key_exists('login', $userAssigned['user'])) {
                    $userToDo = $userRepository->findOneBy(['username' => $userAssigned['user']['login']]);
                    if ($userToDo) {
                        $taskHR->addUser($userToDo);
                    }
                }
            }
            if ($task['closed_on'] != null) {
                $timeEnd = mb_substr($task['closed_on'],0,10);
                $timeEnd = DateTime::createFromFormat("Y-m-d", $timeEnd );
                $taskHR->setCloseDate($timeEnd);
            }
            if ($task['closed_on'] == null && $task['updated_on'] != null)
            {
                $timeUpdate = mb_substr($task['updated_on'],0,10);
                $timeUpdate = DateTime::createFromFormat("Y-m-d", $timeUpdate);
                $taskHR->setUpdateOn($timeUpdate);
            }
            $taskHR->setProjectTask($projectsRepository->find($task['project']['id']));
            $entityManager->persist($taskHR);
            $entityManager->flush();
        }
        $timeEntities = $this->client->getApi('time_entry')->all();
        foreach ($timeEntities['time_entries'] as $timeEntity) {

            if (!$timeEntriesRepository->find($timeEntity['id'])) {
                $timeEntityHr = new TimeEntries();
                $timeEntityHr->setId($timeEntity['id']);
            }
            else {
                $timeEntityHr = $timeEntriesRepository->find($timeEntity['id']);
            }
            $timeEntityHr->setHours($timeEntity['hours']);
            $timeEntityHr->setTaskAdded($taskRepository->find($timeEntity['issue']['id']));
            $entityManager->persist($timeEntityHr);
            $entityManager->flush();
        }
        $answer = new AnswearDTO();
        $answer->status = 'Sync';
        $answer->messageAnswear = "Sync " . $tasks['total_count'];
        return $this->json($answer, Response::HTTP_OK);
    }

    #[Route('/tasks', name: 'app_tasks', methods: "GET")]
    public function getTasks(TaskRepository $taskRepository,){
        return $this->json($this->tasksResponseDTOTransformer->transformFromObjects($taskRepository->findAll()));
    }

}
