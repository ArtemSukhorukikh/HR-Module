<?php

namespace App\Entity;

use App\Repository\SurveyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SurveyRepository::class)
 */
class Survey
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=3000)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\OneToOne(targetEntity=ApplicationPurchaseOfTraining::class, inversedBy="survey", cascade={"persist", "remove"})
     */
    private $describe;

    /**
     * @ORM\OneToMany(targetEntity=ResponeSurvey::class, mappedBy="survey", orphanRemoval=true)
     */
    private $responeSurveys;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function __construct()
    {
        $this->responeSurveys = new ArrayCollection();
    }

    /**
     * @ORM\OneToOne(targetEntity=ApplicationPurchaseOfTraining::class, cascade={"persist", "remove"})
     */

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    public function getDescribe(): ?ApplicationPurchaseOfTraining
    {
        return $this->describe;
    }

    public function setDescribe(?ApplicationPurchaseOfTraining $describe): self
    {
        $this->describe = $describe;

        return $this;
    }

    /**
     * @return Collection<int, ResponeSurvey>
     */
    public function getResponeSurveys(): Collection
    {
        return $this->responeSurveys;
    }

    public function addResponeSurvey(ResponeSurvey $responeSurvey): self
    {
        if (!$this->responeSurveys->contains($responeSurvey)) {
            $this->responeSurveys[] = $responeSurvey;
            $responeSurvey->setSurvey($this);
        }

        return $this;
    }

    public function removeResponeSurvey(ResponeSurvey $responeSurvey): self
    {
        if ($this->responeSurveys->removeElement($responeSurvey)) {
            // set the owning side to null (unless already changed)
            if ($responeSurvey->getSurvey() === $this) {
                $responeSurvey->setSurvey(null);
            }
        }

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
}
