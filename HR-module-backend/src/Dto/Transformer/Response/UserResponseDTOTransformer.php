<?php

namespace App\Dto\Transformer\Response;

use App\Dto\ContactDTO;
use App\Dto\UserCurrentDto;
use App\Dto\UserDto;
use App\Entity\Contacts;
use App\Entity\Projects;
use App\Entity\User;
use App\Repository\ProjectsRepository;
use App\Repository\TaskRepository;
use phpDocumentor\Reflection\Types\Array_;

class UserResponseDTOTransformer extends AbstractResponceDTOTransformer
{
    public TasksResponseDTOTransformer $tasksResponseDTOTransformer;
    public ProjectsResponseDTOTransformer $projectsResponseDTOTransformer;
    public TaskRepository $taskRepository;
    public ContactResponseDTOTransformer $contactResponseDTOTransformer;
    public ProjectsRepository $projectsRepository;
    public function __construct(TasksResponseDTOTransformer $tasksResponseDTOTransformer,
                                ProjectsResponseDTOTransformer $projectsResponseDTOTransformer,
                                ProjectsRepository $projectsRepository,
                                ContactResponseDTOTransformer $contactResponseDTOTransformer,
    TaskRepository $taskRepository)
    {
        $this->tasksResponseDTOTransformer = $tasksResponseDTOTransformer;
        $this->projectsResponseDTOTransformer = $projectsResponseDTOTransformer;
        $this->projectsRepository = $projectsRepository;
        $this->contactResponseDTOTransformer = $contactResponseDTOTransformer;
        $this->taskRepository = $taskRepository;
    }

    /**
     * @param User $user
     */
    public function transformFromObject($user)
    {
        $dto = new UserCurrentDto();
        $dto->id = $user->getId();
        $dto->username = $user->getUserIdentifier();
        $dto->roles = $user->getRoles();
        $dto->userInfo = new UserDto();
        $dto->userInfo->firstname = $user->getFirstName();
        $dto->userInfo->lastname = $user->getLastName();
        $dto->userInfo->patronymic = $user->getPatronymic();
        $dto->userInfo->dateofhiring = $user->getDateOfHiring()->format("Y-m-d");
        $dto->userInfo->position = $user->getPosition();
        $usersTasks = $user->getTasks();
        $dto->tasks = $this->tasksResponseDTOTransformer->transformFromObjects($usersTasks);
        $usersProjects = [];
        foreach ($usersTasks as $task) {
            $userProjectsInTask = $task->getProjectTask();
            if ($usersProjects !== null) {
                $usersProjects[] = $userProjectsInTask->getId();
            }
        }
        $usersProjects = array_unique($usersProjects);
        $usersProjectsUniq = [];
        foreach ($usersProjects as $project) {
            $usersProjectsUniq[] = $this->projectsRepository->find($project);
        }
        $dto->projects = $this->projectsResponseDTOTransformer->transformFromObjects($usersProjectsUniq);
        $dto->contacts = $this->contactResponseDTOTransformer->transformFromObjects($user->getContacts());
        $dto->speed = $user->countSpeedTask();
        $dto->hours = $user->countHoursInMounth();
        $dto->avgMark = $user->avgMarkMounth();
        $dto->avgAch = $user->achivmentsAvg();
        $dto->taskInWork = $user->tasksInWork();
        $dto->effectiveness = 0.6 * $dto->hours - 0.2 * $dto->speed - 0.2 * $dto->taskInWork + 0.1 * $user->avgMarkMounth() + $dto->avgAch;
        return $dto;
    }
}