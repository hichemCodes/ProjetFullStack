<?php

namespace App\Entity;

use App\Repository\AdresseRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;


/**
 * @ApiResource()
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
        return $this->vile_id;
    }

    public function setVilleId(?Ville $vile_id): self
    {
        $this->vile_id = $vile_id;

        return $this;
    }
}
