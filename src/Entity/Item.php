<?php

namespace App\Entity;

use App\Repository\ItemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ItemRepository::class)]
#[ApiResource]
class Item
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:item:data'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['write:item:data','read:item:data'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['write:item:data','read:item:data'])]
    private ?float $quantity = null;

    #[ORM\Column]
    #[Groups(['write:item:data','read:item:data'])]
    private ?float $unit_price_ht = null;

    #[ORM\Column]
    #[Groups(['write:item:data','read:item:data'])]
    private ?float $total_ht = null;

    #[ORM\Column(length: 5, nullable: true)]
    #[Groups(['write:item:data','read:item:data'])]
    private ?string $currency = null;

    #[ORM\Column]
    #[Groups(['write:item:data','read:item:data'])]
    private ?int $tva = null;

    #[ORM\ManyToOne(inversedBy: 'items')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Facture $facture = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnitPriceHt(): ?float
    {
        return $this->unit_price_ht;
    }

    public function setUnitPriceHt(float $unit_price_ht): self
    {
        $this->unit_price_ht = $unit_price_ht;

        return $this;
    }

    public function getTotalHt(): ?float
    {
        return $this->total_ht;
    }

    public function setTotalHt(float $total_ht): self
    {
        $this->total_ht = $total_ht;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(?string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getTva(): ?int
    {
        return $this->tva;
    }

    public function setTva(int $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(?Facture $facture): self
    {
        $this->facture = $facture;

        return $this;
    }
}
