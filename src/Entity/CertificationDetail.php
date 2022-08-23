<?php

namespace App\Entity;

use App\Repository\CertificationDetailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CertificationDetailRepository::class)]
class CertificationDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'certificationDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $certified = null;

    #[ORM\ManyToOne(inversedBy: 'certificationDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Certification $certification = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $obtainDate = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $mark = null;

    #[ORM\Column(nullable: true)]
    private ?bool $authentic = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCertified(): ?User
    {
        return $this->certified;
    }

    public function setCertified(?User $certified): self
    {
        $this->certified = $certified;
        if (!$certified->certificationDetails->contains($this)) {
            $certified->addCertificationDetail($this);
        }

        return $this;
    }

    public function getCertification(): ?Certification
    {
        return $this->certification;
    }

    public function setCertification(?Certification $certification): self
    {
        $this->certification = $certification;
        if (!$certification->certificationDetails->contains($this)) {
            $certification->addCertificationDetail($this);
        }

        return $this;
    }

    public function getObtainDate(): ?\DateTimeInterface
    {
        return $this->obtainDate;
    }

    public function setObtainDate(\DateTimeInterface $obtainDate): self
    {
        $this->obtainDate = $obtainDate;

        return $this;
    }

    public function getMark(): ?string
    {
        return $this->mark;
    }

    public function setMark(?string $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function isAuthentic(): ?bool
    {
        return $this->authentic;
    }

    public function setAuthentic(?bool $authentic): self
    {
        $this->authentic = $authentic;

        return $this;
    }
}
