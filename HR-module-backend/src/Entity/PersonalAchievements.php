<?php

namespace App\Entity;

use App\Repository\PersonalAchievementsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PersonalAchievementsRepository::class)
 */
class PersonalAchievements
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
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="personalAchievements")
     */
    private $userAchivment;

    public function __construct()
    {
        $this->userAchivment = new ArrayCollection();
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

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(float $value): self
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserAchivment(): Collection
    {
        return $this->userAchivment;
    }

    public function addUserAchivment(User $userAchivment): self
    {
        if (!$this->userAchivment->contains($userAchivment)) {
            $this->userAchivment[] = $userAchivment;
        }

        return $this;
    }

    public function removeUserAchivment(User $userAchivment): self
    {
        $this->userAchivment->removeElement($userAchivment);

        return $this;
    }
}
