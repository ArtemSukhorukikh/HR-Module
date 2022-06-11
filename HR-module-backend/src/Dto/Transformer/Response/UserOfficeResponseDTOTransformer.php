<?php

namespace App\Dto\Transformer\Response;

use App\Dto\ContactDTO;
use App\Dto\UserCurrentDto;
use App\Dto\UserDto;
use App\Dto\UserOfficeDto;
use App\Entity\Contacts;
use App\Entity\Projects;
use App\Entity\User;
use App\Repository\ProjectsRepository;
use App\Repository\TaskRepository;
use phpDocumentor\Reflection\Types\Array_;

class UserOfficeResponseDTOTransformer extends AbstractResponceDTOTransformer
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
        $dto = new UserOfficeDto();

        $dto->username = $user->getUserIdentifier();
        $dto->userInfo = new UserDto();
        $dto->userInfo->firstname = $user->getFirstName();
        $dto->userInfo->lastname = $user->getLastName();
        $dto->userInfo->patronymic = $user->getPatronymic();
        $dto->userInfo->dateofhiring = $user->getDateOfHiring()->format("Y-m-d");
        $dto->userInfo->position = $user->getPosition();
        $usersTasks = $user->getTasks();
        $dto->contacts = $this->contactResponseDTOTransformer->transformFromObjects($user->getContacts());
        return $dto;
    }
}