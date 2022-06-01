<?php

namespace App\Entity;

use App\Repository\FeedbackRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FeedbackRepository::class)
 */
class Feedback
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
    private $date;

    /**
     * @ORM\Column(type="integer")
     */
    private $estimation;

    /**
     * @ORM\Column(type="string", length=3000)
     */
    private $note;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="writing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $authon;

    /**
     * @ORM\ManyToOne(targetEntity=EducationalResources::class, inversedBy="makesRating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $educationalResources;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEstimation(): ?int
    {
        return $this->estimation;
    }

    public function setEstimation(int $estimation): self
    {
        $this->estimation = $estimation;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getAuthon(): ?User
    {
        return $this->authon;
    }

    public function setAuthon(?User $authon): self
    {
        $this->authon = $authon;

        return $this;
    }

    public function getEducationalResources(): ?EducationalResources
    {
        return $this->educationalResources;
    }

    public function setEducationalResources(?EducationalResources $educationalResources): self
    {
        $this->educationalResources = $educationalResources;

        return $this;
    }
}
