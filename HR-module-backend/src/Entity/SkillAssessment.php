<?php

namespace App\Entity;

use App\Repository\SkillAssessmentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SkillAssessmentRepository::class)
 */
class SkillAssessment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $estimation;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="skillAssessments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_;

    /**
     * @ORM\ManyToOne(targetEntity=Skills::class, inversedBy="skillAssessments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skills;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEstimation(): ?int
    {
        return $this->estimation;
    }

    public function setEstimation(int $estimation): self
    {
        $this->estimation = $estimation;

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

    public function getUser(): ?User
    {
        return $this->user_;
    }

    public function setUser(?User $user_): self
    {
        $this->user_ = $user_;

        return $this;
    }

    public function getSkills(): ?Skills
    {
        return $this->skills;
    }

    public function setSkills(?Skills $skills): self
    {
        $this->skills = $skills;

        return $this;
    }
}
