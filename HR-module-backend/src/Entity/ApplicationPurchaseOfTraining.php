<?php

namespace App\Entity;

use App\Repository\ApplicationPurchaseOfTrainingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApplicationPurchaseOfTrainingRepository::class)
 */
class ApplicationPurchaseOfTraining
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3000)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="applicationPurchaseOfTrainings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $compose;

    /**
     * @ORM\OneToOne(targetEntity=Survey::class, mappedBy="describe", cascade={"persist", "remove"})
     */
    private $survey;

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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

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

    public function getSurvey(): ?Survey
    {
        return $this->survey;
    }

    public function setSurvey(?Survey $survey): self
    {
        // unset the owning side of the relation if necessary
        if ($survey === null && $this->survey !== null) {
            $this->survey->setDescribe(null);
        }

        // set the owning side of the relation if necessary
        if ($survey !== null && $survey->getDescribe() !== $this) {
            $survey->setDescribe($this);
        }

        $this->survey = $survey;

        return $this;
    }
}
