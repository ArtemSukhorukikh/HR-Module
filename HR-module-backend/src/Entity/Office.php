<?php

namespace App\Entity;

use App\Repository\OfficeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OfficeRepository::class)
 */
class Office
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
     * @ORM\Column(type="integer")
     */
    private $floor;

    /**
     * @ORM\OneToMany(targetEntity=Workplace::class, mappedBy="office")
     * @ORM\OrderBy({"id" = "ASC"})
     */
    private $workplaces;

    public function __construct()
    {
        $this->workplaces = new ArrayCollection();
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

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * @return Collection<int, Workplace>
     */
    public function getWorkplaces(): Collection
    {
        return $this->workplaces;
    }

    public function addWorkplace(Workplace $workplace): self
    {
        if (!$this->workplaces->contains($workplace)) {
            $this->workplaces[] = $workplace;
            $workplace->setOffice($this);
        }

        return $this;
    }

    public function removeWorkplace(Workplace $workplace): self
    {
        if ($this->workplaces->removeElement($workplace)) {
            // set the owning side to null (unless already changed)
            if ($workplace->getOffice() === $this) {
                $workplace->setOffice(null);
            }
        }

        return $this;
    }
}
