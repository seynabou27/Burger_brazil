<?php

namespace App\Entity;

use App\Repository\MenusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenusRepository::class)]
class Menus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prix;

    #[ORM\Column(type: 'string', length: 1500)]
    private $detail;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'menus')]
    private $commandes;

    #[ORM\OneToMany(mappedBy: 'menus', targetEntity: Image::class, cascade:(["persist"]))]
    private $imagess;

    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuses')]
    private $burgerss;  

    #[ORM\ManyToMany(targetEntity: Complement::class, inversedBy: 'menuses')]
    private $complements;

    #[ORM\Column(type: 'string', length: 255)]
    private $etat;

    #[ORM\Column(type: 'string', length: 255)]
    private $Type;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->imagess = new ArrayCollection();
        $this->complements = new ArrayCollection();
        $this->etat = 'non_archiver';
        $this->Type ='menu';


    }


    public function getId(): ?int
    {
        return $this->id;
    }

    

    /**
     * Get the value of nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     */
    public function setNom($nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get the value of prix
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set the value of prix
     */
    public function setPrix($prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get the value of detail
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set the value of detail
     */
    public function setDetail($detail): self
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addMenu($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeMenu($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImagess(): Collection
    {
        return $this->imagess;
    }

    public function addImagess(Image $imagess): self
    {
        if (!$this->imagess->contains($imagess)) {
            $this->imagess[] = $imagess;
            $imagess->setMenus($this);
        }

        return $this;
    }

    public function removeImagess(Image $imagess): self
    {
        if ($this->imagess->removeElement($imagess)) {
            // set the owning side to null (unless already changed)
            if ($imagess->getMenus() === $this) {
                $imagess->setMenus(null);
            }
        }

        return $this;
    }

    public function getBurgerss(): ?Burger
    {
        return $this->burgerss;
    }

    public function setBurgerss(?Burger $burgerss): self
    {
        $this->burgerss = $burgerss;

        return $this;
    }

    /**
     * @return Collection<int, Complement>
     */
    public function getComplements(): Collection
    {
        return $this->complements;
    }

    public function addComplement(Complement $complement): self
    {
        if (!$this->complements->contains($complement)) {
            $this->complements[] = $complement;
        }

        return $this;
    }

    public function removeComplement(Complement $complement): self
    {
        $this->complements->removeElement($complement);

        return $this;
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

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(string $Type): self
    {
        $this->Type = $Type;

        return $this;
    }
}
