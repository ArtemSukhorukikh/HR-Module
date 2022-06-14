<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NotificationRepository::class)
 */
class Notification
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
    private $text;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="notifications")
     */
    private $toUser;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function __construct()
    {
        $this->toUser = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getToUser(): Collection
    {
        return $this->toUser;
    }

    public function addToUser(User $toUser): self
    {
        if (!$this->toUser->contains($toUser)) {
            $this->toUser[] = $toUser;
        }

        return $this;
    }

    public function removeToUser(User $toUser): self
    {
        $this->toUser->removeElement($toUser);

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
}
