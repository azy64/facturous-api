<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\FactureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FactureRepository::class)]
#[ApiResource(
    security:"is_granted('ROLE_USER') and object.owner==user",
    operations:[
        new Get(),
        new GetCollection(),
        new Post(
            denormalizationContext:['groups'=>['load:facture','write:facture:data','write:item:data',]],
            normalizationContext:['groups'=>['read:facture:data','read:item:data']],
        ),
        new Patch(),
        new Put(),
        new Delete(),
    ],
)]
/**
 * applied a filter for searching factures
 */
#[ApiFilter(SearchFilter::class,properties:[
    'id'=>'exact',
    'customer'=>'partial',
    'seller'=>'partial',
    'date_paiement'=> 'exact',
    'etatFacture.prop'=>'exact'
    ])]
#[ApiFilter(DateFilter::class, properties:['date_paiement'])]
class Facture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:facture:data'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('load:facture')]
    private ?string $num_fac = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('read:facture:data')]
    private ?\DateTimeInterface $date_vente = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:facture:data','write:facture:data'])]
    private ?string $num_tva = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:facture:data','write:facture:data'])]
    private ?string $num_bon_order = null;

    #[ORM\Column]
    #[Groups(['read:facture:data','write:facture:data'])]
    private ?float $total_amount_ht = null;

    #[ORM\Column]
    #[Groups(['read:facture:data','write:facture:data'])]
    private ?float $total_amount_ttc = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:facture:data','write:facture:data'])]
    private ?string $adresse_fac = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:facture:data','write:facture:data'])]
    private ?string $libelle_fac = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:facture:data','write:facture:data'])]
    private ?string $remise_ht = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('read:facture:data')]
    private ?\DateTimeInterface $date_paiement = null;

    #[ORM\Column(length: 5)]
    #[Groups(['read:facture:data','write:facture:data'])]
    private ?string $currency = null;

    #[ORM\OneToMany(mappedBy: 'facture', targetEntity: Reglement::class, orphanRemoval: true)]
    #[Groups(['read:facture:data','write:facture:data'])]
    private Collection $reglements;

    #[ORM\OneToMany(mappedBy: 'facture', targetEntity: Item::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    #[Groups(['read:facture:data','write:facture:data'])]
    private Collection $items;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:facture:data','write:facture:data'])]
    private ?EtatFacture $etatFacture = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:facture:data','write:facture:data'])]
    private ?Customer $customer = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:facture:data','write:facture:data'])]
    private ?Seller $seller = null;

    public function __construct()
    {
        $this->reglements = new ArrayCollection();
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumFac(): ?string
    {
        return $this->num_fac;
    }

    public function setNumFac(string $num_fac): self
    {
        $this->num_fac = $num_fac;

        return $this;
    }

    public function getDateVente(): ?\DateTimeInterface
    {
        return $this->date_vente;
    }

    public function setDateVente(\DateTimeInterface $date_vente): self
    {
        $this->date_vente = $date_vente;

        return $this;
    }

    public function getNumTva(): ?string
    {
        return $this->num_tva;
    }

    public function setNumTva(string $num_tva): self
    {
        $this->num_tva = $num_tva;

        return $this;
    }

    public function getNumBonOrder(): ?string
    {
        return $this->num_bon_order;
    }

    public function setNumBonOrder(string $num_bon_order): self
    {
        $this->num_bon_order = $num_bon_order;

        return $this;
    }

    public function getTotalAmountHt(): ?float
    {
        return $this->total_amount_ht;
    }

    public function setTotalAmountHt(float $total_amount_ht): self
    {
        $this->total_amount_ht = $total_amount_ht;

        return $this;
    }

    public function getTotalAmountTtc(): ?float
    {
        return $this->total_amount_ttc;
    }

    public function setTotalAmountTtc(float $total_amount_ttc): self
    {
        $this->total_amount_ttc = $total_amount_ttc;

        return $this;
    }

    public function getAdresseFac(): ?string
    {
        return $this->adresse_fac;
    }

    public function setAdresseFac(string $adresse_fac): self
    {
        $this->adresse_fac = $adresse_fac;

        return $this;
    }

    public function getLibelleFac(): ?string
    {
        return $this->libelle_fac;
    }

    public function setLibelleFac(string $libelle_fac): self
    {
        $this->libelle_fac = $libelle_fac;

        return $this;
    }

    public function getRemiseHt(): ?string
    {
        return $this->remise_ht;
    }

    public function setRemiseHt(?string $remise_ht): self
    {
        $this->remise_ht = $remise_ht;

        return $this;
    }

    public function getDatePaiement(): ?\DateTimeInterface
    {
        return $this->date_paiement;
    }

    public function setDatePaiement(\DateTimeInterface $date_paiement): self
    {
        $this->date_paiement = $date_paiement;

        return $this;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * @return Collection<int, Reglement>
     */
    public function getReglements(): Collection
    {
        return $this->reglements;
    }

    public function addReglement(Reglement $reglement): self
    {
        if (!$this->reglements->contains($reglement)) {
            $this->reglements->add($reglement);
            $reglement->setFacture($this);
        }

        return $this;
    }

    public function removeReglement(Reglement $reglement): self
    {
        if ($this->reglements->removeElement($reglement)) {
            // set the owning side to null (unless already changed)
            if ($reglement->getFacture() === $this) {
                $reglement->setFacture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Item>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(Item $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setFacture($this);
        }

        return $this;
    }

    public function removeItem(Item $item): self
    {
        if ($this->items->removeElement($item)) {
            // set the owning side to null (unless already changed)
            if ($item->getFacture() === $this) {
                $item->setFacture(null);
            }
        }

        return $this;
    }

    public function getEtatFacture(): ?EtatFacture
    {
        return $this->etatFacture;
    }

    public function setEtatFacture(EtatFacture $etatFacture): self
    {
        $this->etatFacture = $etatFacture;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getSeller(): ?Seller
    {
        return $this->seller;
    }

    public function setSeller(?Seller $seller): self
    {
        $this->seller = $seller;

        return $this;
    }
}
