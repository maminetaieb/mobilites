<?php

namespace App\Entity;

use App\Repository\MobilityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MobilityRepository::class)]
class Mobility
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'mobilities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Institution $institution = null;

    #[ORM\ManyToMany(targetEntity: Grade::class, inversedBy: 'mobilities')]
    private Collection $grades;

    #[ORM\ManyToMany(targetEntity: Certification::class, inversedBy: 'mobilities')]
    private Collection $certs;

    #[ORM\Column(length: 333)]
    private ?string $name = null;

    #[ORM\Column(length: 888, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $size = null;

    #[ORM\OneToMany(mappedBy: 'mobility', targetEntity: Application::class, orphanRemoval: true)]
    private Collection $applications;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
        $this->certs = new ArrayCollection();
        $this->applications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $this->grades->add($grade);
        }

        return $this;
    }

    public function removeGrade(Grade $grade): self
    {
        $this->grades->removeElement($grade);

        return $this;
    }

    /**
     * @return Collection<int, Certification>
     */
    public function getCerts(): Collection
    {
        return $this->certs;
    }

    public function addCert(Certification $cert): self
    {
        if (!$this->certs->contains($cert)) {
            $this->certs->add($cert);
        }

        return $this;
    }

    public function removeCert(Certification $cert): self
    {
        $this->certs->removeElement($cert);

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): self
    {
        $this->size = $size;

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
            $application->setMobility($this);
        }

        return $this;
    }

    public function removeApplication(Application $application): self
    {
        if ($this->applications->removeElement($application)) {
            // set the owning side to null (unless already changed)
            if ($application->getMobility() === $this) {
                $application->setMobility(null);
            }
        }

        return $this;
    }
}
