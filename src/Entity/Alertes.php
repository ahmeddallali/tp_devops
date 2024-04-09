<?php

namespace App\Entity;

use App\Repository\AlertesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlertesRepository::class)
 */
class Alertes
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
    private $alertes_generales;

    /**
     * @ORM\Column(type="date")
     */
    private $date_debut;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlertesGenerales(): ?string
    {
        return $this->alertes_generales;
    }

    public function setAlertesGenerales(string $alertes_generales): self
    {
        $this->alertes_generales = $alertes_generales;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }



    public function getMatricule(): ?Voiture
    {
        return $this->matricule;
    }

    public function setMatricule(?Voiture $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }
    
}
