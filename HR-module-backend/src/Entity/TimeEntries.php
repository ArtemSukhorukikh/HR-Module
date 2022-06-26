<?php

namespace App\Entity;

use App\Repository\TimeEntriesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TimeEntriesRepository::class)
 */
class TimeEntries
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $hours;

    /**
     * @ORM\ManyToOne(targetEntity=Task::class, inversedBy="timeEntries")
     */
    private $taskAdded;

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHours(): ?float
    {
        return $this->hours;
    }

    public function setHours(float $hours): self
    {
        $this->hours = $hours;

        return $this;
    }

    public function getTaskAdded(): ?Task
    {
        return $this->taskAdded;
    }

    public function setTaskAdded(?Task $taskAdded): self
    {
        $this->taskAdded = $taskAdded;

        return $this;
    }
}
