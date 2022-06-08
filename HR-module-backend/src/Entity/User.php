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

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $patronymic;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $position;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfHiring;

    /**
     * @ORM\Column(type="string", length=3000, nullable=true)
     */
    private $developmentPlan;

    /**
     * @ORM\OneToMany(targetEntity=Feedback::class, mappedBy="authon", orphanRemoval=true)
     */
    private $writing;

    /**
     * @ORM\OneToMany(targetEntity=ApplicationForTraining::class, mappedBy="compose")
     */
    private $applicationForTrainings;

    /**
     * @ORM\OneToMany(targetEntity=ApplicationPurchaseOfTraining::class, mappedBy="compose")
     */
    private $applicationPurchaseOfTrainings;

    /**
     * @ORM\OneToMany(targetEntity=ResponeSurvey::class, mappedBy="user_", orphanRemoval=true)
     */
    private $responeSurveys;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->grades = new ArrayCollection();
        $this->personalAchievements = new ArrayCollection();
        $this->writing = new ArrayCollection();
        $this->applicationForTrainings = new ArrayCollection();
        $this->applicationPurchaseOfTrainings = new ArrayCollection();
        $this->responeSurveys = new ArrayCollection();
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(string $patronymic): self
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getDateOfHiring(): ?\DateTimeInterface
    {
        return $this->dateOfHiring;
    }

    public function setDateOfHiring(\DateTimeInterface $dateOfHiring): self
    {
        $this->dateOfHiring = $dateOfHiring;

        return $this;
    }

    public function getDevelopmentPlan(): ?string
    {
        return $this->developmentPlan;
    }

    public function setDevelopmentPlan(?string $developmentPlan): self
    {
        $this->developmentPlan = $developmentPlan;

        return $this;
    }

    /**
     * @return Collection<int, Feedback>
     */
    public function getWriting(): Collection
    {
        return $this->writing;
    }

    public function addWriting(Feedback $writing): self
    {
        if (!$this->writing->contains($writing)) {
            $this->writing[] = $writing;
            $writing->setAuthon($this);
        }

        return $this;
    }

    public function removeWriting(Feedback $writing): self
    {
        if ($this->writing->removeElement($writing)) {
            // set the owning side to null (unless already changed)
            if ($writing->getAuthon() === $this) {
                $writing->setAuthon(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ApplicationForTraining>
     */
    public function getApplicationForTrainings(): Collection
    {
        return $this->applicationForTrainings;
    }

    public function addApplicationForTraining(ApplicationForTraining $applicationForTraining): self
    {
        if (!$this->applicationForTrainings->contains($applicationForTraining)) {
            $this->applicationForTrainings[] = $applicationForTraining;
            $applicationForTraining->setCompose($this);
        }

        return $this;
    }

    public function removeApplicationForTraining(ApplicationForTraining $applicationForTraining): self
    {
        if ($this->applicationForTrainings->removeElement($applicationForTraining)) {
            // set the owning side to null (unless already changed)
            if ($applicationForTraining->getCompose() === $this) {
                $applicationForTraining->setCompose(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ApplicationPurchaseOfTraining>
     */
    public function getApplicationPurchaseOfTrainings(): Collection
    {
        return $this->applicationPurchaseOfTrainings;
    }

    public function addApplicationPurchaseOfTraining(ApplicationPurchaseOfTraining $applicationPurchaseOfTraining): self
    {
        if (!$this->applicationPurchaseOfTrainings->contains($applicationPurchaseOfTraining)) {
            $this->applicationPurchaseOfTrainings[] = $applicationPurchaseOfTraining;
            $applicationPurchaseOfTraining->setCompose($this);
        }

        return $this;
    }

    public function removeApplicationPurchaseOfTraining(ApplicationPurchaseOfTraining $applicationPurchaseOfTraining): self
    {
        if ($this->applicationPurchaseOfTrainings->removeElement($applicationPurchaseOfTraining)) {
            // set the owning side to null (unless already changed)
            if ($applicationPurchaseOfTraining->getCompose() === $this) {
                $applicationPurchaseOfTraining->setCompose(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ResponeSurvey>
     */
    public function getResponeSurveys(): Collection
    {
        return $this->responeSurveys;
    }

    public function addResponeSurvey(ResponeSurvey $responeSurvey): self
    {
        if (!$this->responeSurveys->contains($responeSurvey)) {
            $this->responeSurveys[] = $responeSurvey;
            $responeSurvey->setUser($this);
        }

        return $this;
    }

    public function removeResponeSurvey(ResponeSurvey $responeSurvey): self
    {
        if ($this->responeSurveys->removeElement($responeSurvey)) {
            // set the owning side to null (unless already changed)
            if ($responeSurvey->getUser() === $this) {
                $responeSurvey->setUser(null);
            }
        }

        return $this;
    }
}
