<?php

namespace App\Entity;

use App\Repository\MenusRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenusRepository::class)]
class Menus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom_menu;

    #[ORM\Column(type: 'string', length: 255)]
    private $prix_menu;

    #[ORM\Column(type: 'string', length: 1500)]
    private $detail_menu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomMenu(): ?string
    {
        return $this->nom_menu;
    }

    public function setNomMenu(string $nom_menu): self
    {
        $this->nom_menu = $nom_menu;

        return $this;
    }

    public function getPrixMenu(): ?string
    {
        return $this->prix_menu;
    }

    public function setPrixMenu(string $prix_menu): self
    {
        $this->prix_menu = $prix_menu;

        return $this;
    }

    public function getDetailMenu(): ?string
    {
        return $this->detail_menu;
    }

    public function setDetailMenu(string $detail_menu): self
    {
        $this->detail_menu = $detail_menu;

        return $this;
    }
}
