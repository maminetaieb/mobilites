<?php

namespace App\Entity;

use App\Repository\CertificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CertificationRepository::class)]
class Certification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    private ?string $name = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $field = null;

    #[ORM\Column]
    private ?bool $stringMarksAllowed = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $markDescription = null;

    #[ORM\OneToMany(mappedBy: 'certification', targetEntity: CertificationDetail::class)]
    private Collection $certificationDetails;

    #[ORM\ManyToMany(targetEntity: Mobility::class, mappedBy: 'certs')]
    private Collection $mobilities;

    public function __construct()
    {
        $this->certificationDetails = new ArrayCollection();
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

    public function getField(): ?string
    {
        return $this->field;
    }

    public function setField(?string $field): self
    {
        $this->field = $field;

        return $this;
    }

    public function isStringMarksAllowed(): ?bool
    {
        return $this->stringMarksAllowed;
    }

    public function setStringMarksAllowed(bool $stringMarksAllowed): self
    {
        $this->stringMarksAllowed = $stringMarksAllowed;

        return $this;
    }

    public function getMarkDescription(): ?string
    {
        return $this->markDescription;
    }

    public function setMarkDescription(?string $markDescription): self
    {
        $this->markDescription = $markDescription;

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
            $certificationDetail->setCertification($this);
        }

        return $this;
    }

    public function removeCertificationDetail(CertificationDetail $certificationDetail): self
    {
        if ($this->certificationDetails->removeElement($certificationDetail)) {
            // set the owning side to null (unless already changed)
            if ($certificationDetail->getCertification() === $this) {
                $certificationDetail->setCertification(null);
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
            $mobility->addCert($this);
        }

        return $this;
    }

    public function removeMobility(Mobility $mobility): self
    {
        if ($this->mobilities->removeElement($mobility)) {
            $mobility->removeCert($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
