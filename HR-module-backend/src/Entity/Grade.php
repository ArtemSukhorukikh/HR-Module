<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GradeRepository::class)
 */
class Grade
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
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="grades")
     */
    private $user_grade;

    public function __construct()
    {
        $this->user_grade = new ArrayCollection();
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
    public function getUserGrade(): Collection
    {
        return $this->user_grade;
    }

    public function addUserGrade(User $userGrade): self
    {
        if (!$this->user_grade->contains($userGrade)) {
            $this->user_grade[] = $userGrade;
        }

        return $this;
    }

    public function removeUserGrade(User $userGrade): self
    {
        $this->user_grade->removeElement($userGrade);

        return $this;
    }
}
