<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $numero_commande;

    #[ORM\Column(type: 'string', length: 255)]
    private $date_commande;

    #[ORM\Column(type: 'string', length: 255)]
    private $etat_commande;

    #[ORM\Column(type: 'integer')]
    private $telephone_commande;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commandes')]
    private $user;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCommande(): ?string
    {
        return $this->numero_commande;
    }

    public function setNumeroCommande(string $numero_commande): self
    {
        $this->numero_commande = $numero_commande;

        return $this;
    }

    public function getDateCommande(): ?string
    {
        return $this->date_commande;
    }

    public function setDateCommande(string $date_commande): self
    {
        $this->date_commande = $date_commande;

        return $this;
    }

    public function getEtatCommande(): ?string
    {
        return $this->etat_commande;
    }

    public function setEtatCommande(string $etat_commande): self
    {
        $this->etat_commande = $etat_commande;

        return $this;
    }

    public function getTelephoneCommande(): ?int
    {
        return $this->telephone_commande;
    }

    public function setTelephoneCommande(int $telephone_commande): self
    {
        $this->telephone_commande = $telephone_commande;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    
}
