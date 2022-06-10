<?php

namespace App\Entity;

use App\Repository\CompetenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompetenceRepository::class)
 */
class Competence
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
     * @ORM\Column(type="string", length=3000)
     */
    private $description;

    /**
     * @ORM\ManyToMany(targetEntity=EducationalResources::class, inversedBy="competences")
     */
    private $educationalResources;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, inversedBy="competences")
     */
    private $includes;

    /**
     * @ORM\ManyToMany(targetEntity=Competence::class, mappedBy="includes")
     */
    private $competences;

    /**
     * @ORM\ManyToMany(targetEntity=Skills::class, mappedBy="competence")
     */
    private $skills;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="competences")
     */
    private $users;

    public function __construct()
    {
        $this->educationalResources = new ArrayCollection();
        $this->includes = new ArrayCollection();
        $this->competences = new ArrayCollection();
        $this->skills = new ArrayCollection();
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

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, EducationalResources>
     */
    public function getEducationalResources(): Collection
    {
        return $this->educationalResources;
    }

    public function addEducationalResource(EducationalResources $educationalResource): self
    {
        if (!$this->educationalResources->contains($educationalResource)) {
            $this->educationalResources[] = $educationalResource;
        }

        return $this;
    }

    public function removeEducationalResource(EducationalResources $educationalResource): self
    {
        $this->educationalResources->removeElement($educationalResource);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getIncludes(): Collection
    {
        return $this->includes;
    }

    public function addInclude(self $include): self
    {
        if (!$this->includes->contains($include)) {
            $this->includes[] = $include;
        }

        return $this;
    }

    public function removeInclude(self $include): self
    {
        $this->includes->removeElement($include);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCompetences(): Collection
    {
        return $this->competences;
    }

    public function addCompetence(self $competence): self
    {
        if (!$this->competences->contains($competence)) {
            $this->competences[] = $competence;
            $competence->addInclude($this);
        }

        return $this;
    }

    public function removeCompetence(self $competence): self
    {
        if ($this->competences->removeElement($competence)) {
            $competence->removeInclude($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Skills>
     */
    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function addSkill(Skills $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills[] = $skill;
            $skill->addCompetence($this);
        }

        return $this;
    }

    public function removeSkill(Skills $skill): self
    {
        if ($this->skills->removeElement($skill)) {
            $skill->removeCompetence($this);
        }

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(?int $type): self
    {
        $this->type = $type;

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
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }
}
