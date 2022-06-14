<?php

namespace App\Entity;

use App\Repository\TaskEvaluationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TaskEvaluationRepository::class)
 */
class TaskEvaluation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\OneToOne(targetEntity=Task::class, inversedBy="taskEvaluation")
     * @ORM\JoinColumn(nullable=true)
     */
    private $toTask;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getToTask(): ?Task
    {
        return $this->toTask;
    }

    public function setToTask(Task $toTask): self
    {
        $this->toTask = $toTask;

        return $this;
    }
}
