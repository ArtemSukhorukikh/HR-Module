<?php

namespace App\Entity;

use App\Repository\DepartmentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DepartmentRepository::class)
 */
class Department
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
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="works")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Survey::class, mappedBy="deparment")
     */
    private $surveys;

    /**
     * @ORM\OneToOne(targetEntity=Competence::class, inversedBy="department", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $mainCompetence;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="directs", cascade={"persist", "remove"})
     */
    private $director;

    /**
     * @ORM\OneToOne(targetEntity=Department::class, inversedBy="department", cascade={"persist", "remove"})
     */
    private $Obeys;

    /**
     * @ORM\OneToOne(targetEntity=Department::class, mappedBy="Obeys", cascade={"persist", "remove"})
     */
    private $department;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->surveys = new ArrayCollection();
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
            $user->setWorks($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getWorks() === $this) {
                $user->setWorks(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Survey>
     */
    public function getSurveys(): Collection
    {
        return $this->surveys;
    }

    public function addSurvey(Survey $survey): self
    {
        if (!$this->surveys->contains($survey)) {
            $this->surveys[] = $survey;
            $survey->setDeparment($this);
        }

        return $this;
    }

    public function removeSurvey(Survey $survey): self
    {
        if ($this->surveys->removeElement($survey)) {
            // set the owning side to null (unless already changed)
            if ($survey->getDeparment() === $this) {
                $survey->setDeparment(null);
            }
        }

        return $this;
    }

    public function getMainCompetence(): ?Competence
    {
        return $this->mainCompetence;
    }

    public function setMainCompetence(Competence $mainCompetence): self
    {
        $this->mainCompetence = $mainCompetence;

        return $this;
    }

    public function getDirector(): ?User
    {
        return $this->director;
    }

    public function setDirector(?User $director): self
    {
        // unset the owning side of the relation if necessary
        if ($director === null && $this->director !== null) {
            $this->director->setDirects(null);
        }

        // set the owning side of the relation if necessary
        if ($director !== null && $director->getDirects() !== $this) {
            $director->setDirects($this);
        }

        $this->director = $director;

        return $this;
    }

    public function getObeys(): ?self
    {
        return $this->Obeys;
    }

    public function setObeys(?self $Obeys): self
    {
        $this->Obeys = $Obeys;

        return $this;
    }

    public function getDepartment(): ?self
    {
        return $this->department;
    }

    public function setDepartment(?self $department): self
    {
        // unset the owning side of the relation if necessary
        if ($department === null && $this->department !== null) {
            $this->department->setObeys(null);
        }

        // set the owning side of the relation if necessary
        if ($department !== null && $department->getObeys() !== $this) {
            $department->setObeys($this);
        }

        $this->department = $department;

        return $this;
    }
}
