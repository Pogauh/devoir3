<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Serializer\Annotation\Groups;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

#[ApiResource( 
    operations:[new Get(normalizationContext:['groups'=>'produit:item']),
            new GetCollection(normalizationContext:['groups'=>'produit:list']),
            ]
            )]
            #[ApiFilter(OrderFilter::class, properties:['nom' => 'ASC'])]
            


#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ApiResource]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[groups(['produit:list','produit:item','type:list','type:item'])]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $quantiteStock = null;

    #[ORM\Column]
    private ?int $prixUnite = null;

    #[ORM\ManyToOne(inversedBy: 'produits')]
    #[ORM\JoinColumn(nullable: false)]
    #[groups(['produit:list','produit:item'])]
    private ?Type $type = null;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: DetailVente::class)]
    private Collection $detailVentes;

    public function __construct()
    {
        $this->detailVentes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getQuantiteStock(): ?int
    {
        return $this->quantiteStock;
    }

    public function setQuantiteStock(int $quantiteStock): static
    {
        $this->quantiteStock = $quantiteStock;

        return $this;
    }

    public function getPrixUnite(): ?int
    {
        return $this->prixUnite;
    }

    public function setPrixUnite(int $prixUnite): static
    {
        $this->prixUnite = $prixUnite;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection<int, DetailVente>
     */
    public function getDetailVentes(): Collection
    {
        return $this->detailVentes;
    }

    public function addDetailVente(DetailVente $detailVente): static
    {
        if (!$this->detailVentes->contains($detailVente)) {
            $this->detailVentes->add($detailVente);
            $detailVente->setProduit($this);
        }

        return $this;
    }

    public function removeDetailVente(DetailVente $detailVente): static
    {
        if ($this->detailVentes->removeElement($detailVente)) {
            // set the owning side to null (unless already changed)
            if ($detailVente->getProduit() === $this) {
                $detailVente->setProduit(null);
            }
        }

        return $this;
    }
}
