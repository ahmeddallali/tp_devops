<?php

namespace App\Entity;

use App\Repository\UtilisationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UtilisationsRepository::class)
 */
class Utilisations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $conducteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $distination;

    /**
     * @ORM\Column(type="integer")
     */
    private $kilometrages;

    /**
     * @ORM\Column(type="date")
     */
    private $datedepart;

    /**
     * @ORM\Column(type="date")
     */
    private $datearrive;

    /**
     * @ORM\Column(type="integer")
     */
    private $kilometragearivvage;

    /**
     * @ORM\ManyToOne(targetEntity=Voiture::class, inversedBy="utilisations")
     */
    private $matriculevoiture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConducteur(): ?string
    {
        return $this->conducteur;
    }

    public function setConducteur(string $conducteur): self
    {
        $this->conducteur = $conducteur;

        return $this;
    }

    public function getDistination(): ?string
    {
        return $this->distination;
    }

    public function setDistination(string $distination): self
    {
        $this->distination = $distination;

        return $this;
    }

    public function getKilometrages(): ?int
    {
        return $this->kilometrages;
    }

    public function setKilometrages(int $kilometrages): self
    {
        $this->kilometrages = $kilometrages;

        return $this;
    }

    public function getDatedepart(): ?\DateTimeInterface
    {
        return $this->datedepart;
    }

    public function setDatedepart(\DateTimeInterface $datedepart): self
    {
        $this->datedepart = $datedepart;

        return $this;
    }

    public function getDatearrive(): ?\DateTimeInterface
    {
        return $this->datearrive;
    }

    public function setDatearrive(\DateTimeInterface $datearrive): self
    {
        $this->datearrive = $datearrive;

        return $this;
    }

    public function getKilometragearivvage(): ?int
    {
        return $this->kilometragearivvage;
    }

    public function setKilometragearivvage(int $kilometragearivvage): self
    {
        $this->kilometragearivvage = $kilometragearivvage;

        return $this;
    }

    public function getMatriculevoiture(): ?Voiture
    {
        return $this->matriculevoiture;
    }

    public function setMatriculevoiture(?Voiture $matriculevoiture): self
    {
        $this->matriculevoiture = $matriculevoiture;

        return $this;
    }
}
