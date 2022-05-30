<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="hr_user")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Contacts::class, mappedBy="userContact", orphanRemoval=true)
     */
    private $contacts;

    /**
     * @ORM\OneToOne(targetEntity=Workplace::class, mappedBy="userInWorkplace", cascade={"persist", "remove"})
     */
    private $workplace;

    /**
     * @ORM\ManyToMany(targetEntity=Grade::class, mappedBy="user_grade")
     */
    private $grades;

    /**
     * @ORM\ManyToMany(targetEntity=PersonalAchievements::class, mappedBy="userAchivment")
     */
    private $personalAchievements;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->grades = new ArrayCollection();
        $this->personalAchievements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public static function fromDto($userDto, UserPasswordHasherInterface $passwordHasher): User
    {
        $user = new self();
        $user->setUsername($userDto->username);
        $user->setPassword($passwordHasher->hashPassword($user,$userDto->password));
        return $user;
    }

    /**
     * @return Collection<int, Contacts>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contacts $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setUserContact($this);
        }

        return $this;
    }

    public function removeContact(Contacts $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getUserContact() === $this) {
                $contact->setUserContact(null);
            }
        }

        return $this;
    }

    public function getWorkplace(): ?Workplace
    {
        return $this->workplace;
    }

    public function setWorkplace(?Workplace $workplace): self
    {
        // unset the owning side of the relation if necessary
        if ($workplace === null && $this->workplace !== null) {
            $this->workplace->setUserInWorkplace(null);
        }

        // set the owning side of the relation if necessary
        if ($workplace !== null && $workplace->getUserInWorkplace() !== $this) {
            $workplace->setUserInWorkplace($this);
        }

        $this->workplace = $workplace;

        return $this;
    }

    /**
     * @return Collection<int, Grade>
     */
    public function getGrades(): Collection
    {
        return $this->grades;
    }

    public function addGrade(Grade $grade): self
    {
        if (!$this->grades->contains($grade)) {
            $this->grades[] = $grade;
            $grade->addUserGrade($this);
        }

        return $this;
    }

    public function removeGrade(Grade $grade): self
    {
        if ($this->grades->removeElement($grade)) {
            $grade->removeUserGrade($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, PersonalAchievements>
     */
    public function getPersonalAchievements(): Collection
    {
        return $this->personalAchievements;
    }

    public function addPersonalAchievement(PersonalAchievements $personalAchievement): self
    {
        if (!$this->personalAchievements->contains($personalAchievement)) {
            $this->personalAchievements[] = $personalAchievement;
            $personalAchievement->addUserAchivment($this);
        }

        return $this;
    }

    public function removePersonalAchievement(PersonalAchievements $personalAchievement): self
    {
        if ($this->personalAchievements->removeElement($personalAchievement)) {
            $personalAchievement->removeUserAchivment($this);
        }

        return $this;
    }
}
