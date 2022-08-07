<?php

namespace App\Entity;

use App\Repository\InstitutionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstitutionRepository::class)]
class Institution
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 666, nullable: true)]
    private ?string $photoUrl = null;

    #[ORM\Column(length: 444)]
    private ?string $name = null;

    #[ORM\Column(length: 666, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?float $longitude = null;

    #[ORM\Column(nullable: true)]
    private ?float $latitude = null;

    #[ORM\Column(length: 666, nullable: true)]
    private ?string $website = null;

    #[ORM\OneToMany(mappedBy: 'institution', targetEntity: Grade::class, orphanRemoval: true)]
    private Collection $grades;

    #[ORM\OneToMany(mappedBy: 'institution', targetEntity: Mobility::class, orphanRemoval: true)]
    private Collection $mobilities;

    #[ORM\OneToMany(mappedBy: 'institution', targetEntity: User::class)]
    private Collection $managers;

    public function __construct()
    {
        $this->grades = new ArrayCollection();
        $this->mobilities = new ArrayCollection();
        $this->managers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photoUrl;
    }

    public function setPhotoUrl(?string $photoUrl): self
    {
        $this->photoUrl = $photoUrl;

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

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getWebsite(): ?string
    {
        return $this->website;
    }

    public function setWebsite(?string $website): self
    {
        $this->website = $website;

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
            $grade->setInstitution($this);
        }

        return $this;
    }

    public function removeGrade(Grade $grade): self
    {
        if ($this->grades->removeElement($grade)) {
            // set the owning side to null (unless already changed)
            if ($grade->getInstitution() === $this) {
                $grade->setInstitution(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mobility>
     */
    public function getMobilities(): Collection
    {
        return $this->mobilities;
    }

    public function addMobility(Mobility $mobility): self
    {
        if (!$this->mobilities->contains($mobility)) {
            $this->mobilities->add($mobility);
            $mobility->setInstitution($this);
        }

        return $this;
    }

    public function removeMobility(Mobility $mobility): self
    {
        if ($this->mobilities->removeElement($mobility)) {
            // set the owning side to null (unless already changed)
            if ($mobility->getInstitution() === $this) {
                $mobility->setInstitution(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getManagers(): Collection
    {
        return $this->managers;
    }

    public function addManager(User $manager): self
    {
        if (!$this->managers->contains($manager)) {
            $this->managers->add($manager);
            $manager->setInstitution($this);
        }

        return $this;
    }

    public function removeManager(User $manager): self
    {
        if ($this->managers->removeElement($manager)) {
            // set the owning side to null (unless already changed)
            if ($manager->getInstitution() === $this) {
                $manager->setInstitution(null);
            }
        }

        return $this;
    }
}