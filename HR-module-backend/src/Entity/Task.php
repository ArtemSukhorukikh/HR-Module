<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskRepository::class)
 */
class Task
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $estimated_hours;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $close_date;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="tasks")
     */
    private $userToDo;

    /**
     * @ORM\ManyToOne(targetEntity=Projects::class, inversedBy="tasks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $projectTask;

    /**
     * @ORM\OneToOne(targetEntity=TaskEvaluation::class, mappedBy="toTask", cascade={"persist", "remove"})
     */
    private $taskEvaluation;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="Tasks")
     */
    private $users;

    public function __construct()
    {
        $this->userToDo = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setId(int $id): self {
        $this->id = $id;

        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getEstimatedHours(): ?float
    {
        return $this->estimated_hours;
    }

    public function setEstimatedHours(?float $estimated_hours): self
    {
        $this->estimated_hours = $estimated_hours;

        return $this;
    }

    public function getCloseDate(): ?\DateTimeInterface
    {
        return $this->close_date;
    }

    public function setCloseDate(?\DateTimeInterface $close_date): self
    {
        $this->close_date = $close_date;

        return $this;
    }


    public function getProjectTask(): ?Projects
    {
        return $this->projectTask;
    }

    public function setProjectTask(?Projects $projectTask): self
    {
        $this->projectTask = $projectTask;

        return $this;
    }

    public function getTaskEvaluation(): ?TaskEvaluation
    {
        return $this->taskEvaluation;
    }

    public function setTaskEvaluation(TaskEvaluation $taskEvaluation): self
    {
        // set the owning side of the relation if necessary
        if ($taskEvaluation->getToTask() !== $this) {
            $taskEvaluation->setToTask($this);
        }

        $this->taskEvaluation = $taskEvaluation;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addTask($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeTask($this);
        }

        return $this;
    }
}