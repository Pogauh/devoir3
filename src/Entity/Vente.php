<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\VenteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VenteRepository::class)]
#[ApiResource]
class Vente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    private ?float $total = null;

    #[ORM\ManyToOne(inversedBy: 'ventes')]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'vente', targetEntity: DetailVente::class)]
    private Collection $detailVentes;

    public function __construct()
    {
        $this->detailVentes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): static
    {
        $this->total = $total;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

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
            $detailVente->setVente($this);
        }

        return $this;
    }

    public function removeDetailVente(DetailVente $detailVente): static
    {
        if ($this->detailVentes->removeElement($detailVente)) {
            // set the owning side to null (unless already changed)
            if ($detailVente->getVente() === $this) {
                $detailVente->setVente(null);
            }
        }

        return $this;
    }
}
