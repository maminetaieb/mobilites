<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 333)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

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

    public function __construct()
    {
        $this->certificationDetails = new ArrayCollection();
        $this->applications = new ArrayCollection();
        $this->yearDetails = new ArrayCollection();
    }

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

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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
}
