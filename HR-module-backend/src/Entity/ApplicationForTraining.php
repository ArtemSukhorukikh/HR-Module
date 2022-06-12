<?php

namespace App\Entity;

use App\Repository\ApplicationForTrainingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApplicationForTrainingRepository::class)
 */
class ApplicationForTraining
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $startDate;

    /**
     * @ORM\Column(type="date")
     */
    private $endDate;

    /**
     * @ORM\Column(type="integer")
     */
    private $mathodOfPassage;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="applicationForTrainings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compose;

    /**
     * @ORM\ManyToOne(targetEntity=EducationalResources::class, inversedBy="applicationForTrainings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $included;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getMathodOfPassage(): ?int
    {
        return $this->mathodOfPassage;
    }

    public function setMathodOfPassage(int $mathodOfPassage): self
    {
        $this->mathodOfPassage = $mathodOfPassage;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCompose(): ?User
    {
        return $this->compose;
    }

    public function setCompose(?User $compose): self
    {
        $this->compose = $compose;

        return $this;
    }

    public function getIncluded(): ?EducationalResources
    {
        return $this->included;
    }

    public function setIncluded(?EducationalResources $included): self
    {
        $this->included = $included;

        return $this;
    }
}
