<?php

namespace App\Entity;

use App\Repository\ResponseToRequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponseToRequestRepository::class)
 */
class ResponseToRequest
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
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $note;

    /**
     * @ORM\OneToOne(targetEntity=ApplicationForTraining::class, inversedBy="responseToRequest", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $application;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getApplication(): ?ApplicationForTraining
    {
        return $this->application;
    }

    public function setApplication(ApplicationForTraining $application): self
    {
        $this->application = $application;

        return $this;
    }
}
