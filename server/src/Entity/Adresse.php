<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=AdresseRepository::class)
 */
class Adresse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $complement_adresse;

    /**
     * @ORM\ManyToOne(targetEntity=Ville::class, inversedBy="adresses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ville_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getComplementAdresse(): ?string
    {
        return $this->complement_adresse;
    }

    public function setComplementAdresse(?string $complement_adresse): self
    {
        $this->complement_adresse = $complement_adresse;

        return $this;
    }

    public function getVilleId(): ?Ville
    {
        return $this->ville_id;
    }

    public function setVilleId(?Ville $ville_id): self
    {
        $this->ville_id = $ville_id;

        return $this;
    }
}
