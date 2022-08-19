<?php

namespace App\Entity;

use App\Repository\GradeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GradeRepository::class)]
class Grade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'grades')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Institution $institution = null;

    #[ORM\ManyToMany(targetEntity: Mobility::class, mappedBy: 'grades')]
    private Collection $mobilities;

    public function __construct()
    {
        $this->mobilities = new ArrayCollection();
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
            $mobility->addGrade($this);
        }

        return $this;
    }

    public function removeMobility(Mobility $mobility): self
    {
        if ($this->mobilities->removeElement($mobility)) {
            $mobility->removeGrade($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
