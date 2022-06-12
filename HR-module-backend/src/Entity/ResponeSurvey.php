<?php

namespace App\Entity;

use App\Repository\ResponeSurveyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponeSurveyRepository::class)
 */
class ResponeSurvey
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
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="responeSurveys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_;

    /**
     * @ORM\ManyToOne(targetEntity=Survey::class, inversedBy="responeSurveys")
     * @ORM\JoinColumn(nullable=false)
     */
    private $survey;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?int
    {
        return $this->answer;
    }

    public function setAnswer(int $answer): self
    {
        $this->answer = $answer;

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

    public function getSurvey(): ?Survey
    {
        return $this->survey;
    }

    public function setSurvey(?Survey $survey): self
    {
        $this->survey = $survey;

        return $this;
    }
}
