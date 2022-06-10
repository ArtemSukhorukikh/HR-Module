<?php

namespace App\Entity;

use App\Repository\SkillsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillsRepository::class)
 */
class Skills
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
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="skills")
     */
    private $competence;

    /**
     * @ORM\OneToMany(targetEntity=SkillAssessment::class, mappedBy="skills", orphanRemoval=true)
     */
    private $skillAssessments;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
        $this->skillAssessments = new ArrayCollection();
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

    /**
     * @return Collection<int, Competence>
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(Competence $competence): self
    {
        if (!$this->competence->contains($competence)) {
            $this->competence[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competence $competence): self
    {
        $this->competence->removeElement($competence);

        return $this;
    }

    /**
     * @return Collection<int, SkillAssessment>
     */
    public function getSkillAssessments(): Collection
    {
        return $this->skillAssessments;
    }

    public function addSkillAssessment(SkillAssessment $skillAssessment): self
    {
        if (!$this->skillAssessments->contains($skillAssessment)) {
            $this->skillAssessments[] = $skillAssessment;
            $skillAssessment->setSkills($this);
        }

        return $this;
    }

    public function removeSkillAssessment(SkillAssessment $skillAssessment): self
    {
        if ($this->skillAssessments->removeElement($skillAssessment)) {
            // set the owning side to null (unless already changed)
            if ($skillAssessment->getSkills() === $this) {
                $skillAssessment->setSkills(null);
            }
        }

        return $this;
    }
}
