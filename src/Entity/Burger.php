<?php

namespace App\Entity;

use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Authentication\RememberMe\PersistentToken;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
class Burger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $prix;

    #[ORM\Column(type: 'string', length: 255)]
    private $details;

    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: Image::class, cascade:(["persist"]))]
    private $images;

    #[ORM\OneToMany(mappedBy: 'burgerss', targetEntity: Menus::class)]
    private $menuses;

    #[ORM\Column(type: 'string', length: 255)]
    private $etat;

    #[ORM\Column(type: 'string', length: 255)]
    private $Type;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'burger')]
    private $commandes;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->menuses = new ArrayCollection();
        $this->etat = 'non_archiver';
        $this->Type ='burger';
        $this->commandes = new ArrayCollection();
    }

    // #[ORM\OneToMany(mappedBy: 'burgers', targetEntity: Image::class, orphanRemoval: true, cascade:['persist'])]
    // private $images;

    // #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'burger')]
    // private $commandes;


    // public function __construct()
    // {
    //     $this->images = new ArrayCollection();
    //     $this->commandes = new ArrayCollection();
    // }

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
     *
     * @return  self
     */ 
    public function setNom($nom)
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
     *
     * @return  self
     */ 
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    public function __toString()
    {
        return $this ->nom;
    }

    /**
     * Get the value of details
     */ 
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * Set the value of details
     *
     * @return  self
     */ 
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }

    // /**
    //  * @return Collection<int, Image>
    //  */
    // public function getImages(): Collection
    // {
    //     return $this->images;
    // }

    // public function addImage(Image $image): self
    // {
    //     if (!$this->images->contains($image)) {
    //         $this->images[] = $image;
    //         $image->setBurgers($this);
    //     }

    //     return $this;
    // }

    // public function removeImage(Image $image): self
    // {
    //     if ($this->images->removeElement($image)) {
    //         // set the owning side to null (unless already changed)
    //         if ($image->getBurgers() === $this) {
    //             $image->setBurgers(null);
    //         }
    //     }

    //     return $this;
    // }

    // /**
    //  * @return Collection<int, Commande>
    //  */
    // public function getCommandes(): Collection
    // {
    //     return $this->commandes;
    // }

    // public function addCommande(Commande $commande): self
    // {
    //     if (!$this->commandes->contains($commande)) {
    //         $this->commandes[] = $commande;
    //         $commande->addBurger($this);
    //     }

    //     return $this;
    // }

    // public function removeCommande(Commande $commande): self
    // {
    //     if ($this->commandes->removeElement($commande)) {
    //         $commande->removeBurger($this);
    //     }

    //     return $this;
    // }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setBurger($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getBurger() === $this) {
                $image->setBurger(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Menus>
     */
    public function getMenuses(): Collection
    {
        return $this->menuses;
    }

    public function addMenus(Menus $menus): self
    {
        if (!$this->menuses->contains($menus)) {
            $this->menuses[] = $menus;
            $menus->setBurgerss($this);
        }

        return $this;
    }

    public function removeMenus(Menus $menus): self
    {
        if ($this->menuses->removeElement($menus)) {
            // set the owning side to null (unless already changed)
            if ($menus->getBurgerss() === $this) {
                $menus->setBurgerss(null);
            }
        }

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
            $commande->addBurger($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeBurger($this);
        }

        return $this;
    }

    
}
