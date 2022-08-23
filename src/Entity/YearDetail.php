<?php

namespace App\Entity;

use App\Repository\YearDetailRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: YearDetailRepository::class)]
class YearDetail
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'yearDetails')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $student = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Grade $grade = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $moyennes = [];

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $eng = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $fr = null;

    #[ORM\Column]
    private ?int $academicYear = null;

    #[ORM\Column(nullable: true)]
    private ?bool $authentic = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?User
    {
        return $this->student;
    }

    public function setStudent(?User $student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(?Grade $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getMoyennes(): array
    {
        return $this->moyennes;
    }

    public function setMoyennes(array $moyennes): self
    {
        $this->moyennes = $moyennes;

        return $this;
    }

    public function addMoyenne(float $moyenne): self
    {
        array_push($this->moyennes, $moyenne);

        return $this;
    }

    public function removeMoyenne(): self
    {
        array_pop($this->moyennes);

        return $this;
    }

    public function getEng(): ?string
    {
        return $this->eng;
    }

    public function setEng(?string $eng): self
    {
        $this->eng = $eng;

        return $this;
    }

    public function getFr(): ?string
    {
        return $this->fr;
    }

    public function setFr(?string $fr): self
    {
        $this->fr = $fr;

        return $this;
    }

    public function getAcademicYear(): ?int
    {
        return $this->academicYear;
    }

    public function setAcademicYear(int $academicYear): self
    {
        $this->academicYear = $academicYear;

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
