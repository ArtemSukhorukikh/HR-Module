<?php

namespace App\Entity;

use App\Repository\EducationalResourcesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EducationalResourcesRepository::class)
 */
class EducationalResources
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
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=3000)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $link;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity=Feedback::class, mappedBy="educationalResources", orphanRemoval=true)
     */
    private $makesRating;

    /**
     * @ORM\OneToMany(targetEntity=ApplicationForTraining::class, mappedBy="included")
     */
    private $applicationForTrainings;

    public function __construct()
    {
        $this->makesRating = new ArrayCollection();
        $this->applicationForTrainings = new ArrayCollection();
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection<int, Feedback>
     */
    public function getMakesRating(): Collection
    {
        return $this->makesRating;
    }

    public function addMakesRating(Feedback $makesRating): self
    {
        if (!$this->makesRating->contains($makesRating)) {
            $this->makesRating[] = $makesRating;
            $makesRating->setEducationalResources($this);
        }

        return $this;
    }

    public function removeMakesRating(Feedback $makesRating): self
    {
        if ($this->makesRating->removeElement($makesRating)) {
            // set the owning side to null (unless already changed)
            if ($makesRating->getEducationalResources() === $this) {
                $makesRating->setEducationalResources(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ApplicationForTraining>
     */
    public function getApplicationForTrainings(): Collection
    {
        return $this->applicationForTrainings;
    }

    public function addApplicationForTraining(ApplicationForTraining $applicationForTraining): self
    {
        if (!$this->applicationForTrainings->contains($applicationForTraining)) {
            $this->applicationForTrainings[] = $applicationForTraining;
            $applicationForTraining->setIncluded($this);
        }

        return $this;
    }

    public function removeApplicationForTraining(ApplicationForTraining $applicationForTraining): self
    {
        if ($this->applicationForTrainings->removeElement($applicationForTraining)) {
            // set the owning side to null (unless already changed)
            if ($applicationForTraining->getIncluded() === $this) {
                $applicationForTraining->setIncluded(null);
            }
        }

        return $this;
    }
}
