<?php

namespace App\Entity;

use App\Repository\BoutiqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;


/**
 * @ApiResource()
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

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="boutique_id")
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity=Adresse::class, cascade={"persist", "remove"})
     */
    private $adresse_id;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="boutique_id")
     */
    private $produits;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->produits = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setBoutiqueId($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getBoutiqueId() === $this) {
                $user->setBoutiqueId(null);
            }
        }

        return $this;
    }

    public function getAdresseId(): ?Adresse
    {
        return $this->adresse_id;
    }

    public function setAdresseId(?Adresse $adresse_id): self
    {
        $this->adresse_id = $adresse_id;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setBoutiqueId($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getBoutiqueId() === $this) {
                $produit->setBoutiqueId(null);
            }
        }

        return $this;
    }
}
