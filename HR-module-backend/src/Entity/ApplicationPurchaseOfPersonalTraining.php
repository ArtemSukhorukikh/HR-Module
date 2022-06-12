<?php

namespace App\Entity;

use App\Repository\ApplicationPurchaseOfPersonalTrainingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApplicationPurchaseOfPersonalTrainingRepository::class)
 */
class ApplicationPurchaseOfPersonalTraining
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
    private $link;

    /**
     * @ORM\Column(type="string", length=3000)
     */
    private $note;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="applicationPurchaseOfPersonalTrainings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user_;

    /**
     * @ORM\OneToOne(targetEntity=PersonalTraining::class, mappedBy="application", cascade={"persist", "remove"})
     */
    private $personalTraining;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

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

    public function getUser(): ?User
    {
        return $this->user_;
    }

    public function setUser(?User $user_): self
    {
        $this->user_ = $user_;

        return $this;
    }

    public function getPersonalTraining(): ?PersonalTraining
    {
        return $this->personalTraining;
    }

    public function setPersonalTraining(PersonalTraining $personalTraining): self
    {
        // set the owning side of the relation if necessary
        if ($personalTraining->getApplication() !== $this) {
            $personalTraining->setApplication($this);
        }

        $this->personalTraining = $personalTraining;

        return $this;
    }
}
