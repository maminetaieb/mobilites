<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column(length: 300)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'certified', targetEntity: CertificationDetail::class, orphanRemoval: true)]
    private Collection $certificationDetails;

    #[ORM\OneToMany(mappedBy: 'applicant', targetEntity: Application::class, orphanRemoval: true)]
    private Collection $applications;

    #[ORM\OneToMany(mappedBy: 'student', targetEntity: YearDetail::class, orphanRemoval: true)]
    private Collection $yearDetails;

    #[ORM\ManyToOne(inversedBy: 'managers')]
    private ?Institution $institution = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, CertificationDetail>
     */
    public function getCertificationDetails(): Collection
    {
        return $this->certificationDetails;
    }

    public function addCertificationDetail(CertificationDetail $certificationDetail): self
    {
        if (!$this->certificationDetails->contains($certificationDetail)) {
            $this->certificationDetails->add($certificationDetail);
            $certificationDetail->setCertified($this);
        }

        return $this;
    }

    public function removeCertificationDetail(CertificationDetail $certificationDetail): self
    {
        if ($this->certificationDetails->removeElement($certificationDetail)) {
            // set the owning side to null (unless already changed)
            if ($certificationDetail->getCertified() === $this) {
                $certificationDetail->setCertified(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Application>
     */
    public function getApplications(): Collection
    {
        return $this->applications;
    }

    public function addApplication(Application $application): self
    {
        if (!$this->applications->contains($application)) {
            $this->applications->add($application);
            $application->setApplicant($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getApplicant() === $this) {
                $application->setApplicant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, YearDetail>
     */
    public function getYearDetails(): Collection
    {
        return $this->yearDetails;
    }

    public function addYearDetail(YearDetail $yearDetail): self
    {
        if (!$this->yearDetails->contains($yearDetail)) {
            $this->yearDetails->add($yearDetail);
            $yearDetail->setStudent($this);
        }

        return $this;
    }

    public function removeYearDetail(YearDetail $yearDetail): self
    {
        if ($this->yearDetails->removeElement($yearDetail)) {
            // set the owning side to null (unless already changed)
            if ($yearDetail->getStudent() === $this) {
                $yearDetail->setStudent(null);
            }
        }

        return $this;
    }

    public function getInstitution(): ?Institution
    {
        return $this->institution;
    }

    public function setInstitution(?Institution $institution): self
    {
        $this->institution = $institution;

        return $this;
    }

    public function getCurrentYear(): YearDetail
    {
        return $this->yearDetails[array_key_last($this->yearDetails)];
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
