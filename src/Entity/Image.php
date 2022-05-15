<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    // #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'images')]
    // #[ORM\JoinColumn(nullable: false)]
    // private $burger;

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

    // public function getBurger(): ?Burger
    // {
    //     return $this->burger;
    // }

    // public function setBurger(?Burger $burger): self
    // {
    //     $this->burger = $burger;

    //     return $this;
    // }
}
