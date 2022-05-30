<?php

namespace App\Entity;

use App\Repository\WorkplaceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WorkplaceRepository::class)
 */
class Workplace
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
    private $RoomInTheOffice;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="workplace", cascade={"persist", "remove"})
     */
    private $userInWorkplace;

    /**
     * @ORM\ManyToOne(targetEntity=Office::class, inversedBy="workplaces")
     */
    private $office;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoomInTheOffice(): ?int
    {
        return $this->RoomInTheOffice;
    }

    public function setRoomInTheOffice(int $RoomInTheOffice): self
    {
        $this->RoomInTheOffice = $RoomInTheOffice;

        return $this;
    }

    public function getUserInWorkplace(): ?User
    {
        return $this->userInWorkplace;
    }

    public function setUserInWorkplace(?User $userInWorkplace): self
    {
        $this->userInWorkplace = $userInWorkplace;

        return $this;
    }

    public function getOffice(): ?Office
    {
        return $this->office;
    }

    public function setOffice(?Office $office): self
    {
        $this->office = $office;

        return $this;
    }
}
