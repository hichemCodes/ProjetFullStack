<?php

namespace App\Entity;

use App\Repository\BoutiqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BoutiqueRepository::class)
 */
class Boutique
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
    private $nom;

    /**
     * @ORM\Column(type="json")
     */
    private $horaires_de_ouverture = [];

    /**
     * @ORM\Column(type="boolean")
     */
    private $en_conge;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_de_creation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getHorairesDeOuverture(): ?array
    {
        return $this->horaires_de_ouverture;
    }

    public function setHorairesDeOuverture(array $horaires_de_ouverture): self
    {
        $this->horaires_de_ouverture = $horaires_de_ouverture;

        return $this;
    }

    public function isEnConge(): ?bool
    {
        return $this->en_conge;
    }

    public function setEnConge(bool $en_conge): self
    {
        $this->en_conge = $en_conge;

        return $this;
    }

    public function getDateDeCreation(): ?\DateTimeInterface
    {
        return $this->date_de_creation;
    }

    public function setDateDeCreation(\DateTimeInterface $date_de_creation): self
    {
        $this->date_de_creation = $date_de_creation;

        return $this;
    }
}
