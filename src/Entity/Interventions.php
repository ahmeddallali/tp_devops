<?php

namespace App\Entity;

use App\Repository\InterventionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InterventionsRepository::class)
 */
class Interventions
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
    private $etat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_dentretient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_interventions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity=Voiture::class, inversedBy="interventions")
     */
    private $marque;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getTypeDentretient(): ?string
    {
        return $this->type_dentretient;
    }

    public function setTypeDentretient(string $type_dentretient): self
    {
        $this->type_dentretient = $type_dentretient;

        return $this;
    }

    public function getTypeInterventions(): ?string
    {
        return $this->type_interventions;
    }

    public function setTypeInterventions(string $type_interventions): self
    {
        $this->type_interventions = $type_interventions;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getMarque(): ?Voiture
    {
        return $this->marque;
    }

    public function setMarque(?Voiture $marque): self
    {
        $this->marque = $marque;

        return $this;
    }
}
