<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
#[ApiResource(security:"is_granted('ROLE_USER')")]
#[ApiFilter(SearchFilter::class,properties:[
    'id'=>'exact',
    'denomination'=>'partial',
    'nom'=> 'partial',
    'prenom'=>'partial',
    'email'=>'partial',
    'phoneNumber' => 'partial'
    ])]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read:customer:data')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('read:customer:data')]
    private ?string $denomination = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('read:customer:data')]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('read:customer:data')]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Groups('read:customer:data')]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups('read:customer:data')]
    private ?string $adresseCustomer = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('read:customer:data')]
    private ?string $adresseLivraison = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('read:customer:data')]
    private ?string $adresseFacturation = null;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Facture::class, orphanRemoval: true)]
    private Collection $factures;

    #[ORM\Column(length: 12)]
    #[Groups('read:customer:data')]
    private ?string $phoneNumber = null;

    #[ORM\Column]
    #[Groups('read:customer:data')]
    private ?\DateTimeImmutable $createAt = null;

    public function __construct()
    {
        $this->factures = new ArrayCollection();
        $this->createAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdresseCustomer(): ?string
    {
        return $this->adresseCustomer;
    }

    public function setAdresseCustomer(string $adresseCustomer): self
    {
        $this->adresseCustomer = $adresseCustomer;

        return $this;
    }

    public function getAdresseLivraison(): ?string
    {
        return $this->adresseLivraison;
    }

    public function setAdresseLivraison(?string $adresseLivraison): self
    {
        $this->adresseLivraison = $adresseLivraison;

        return $this;
    }

    public function getAdresseFacturation(): ?string
    {
        return $this->adresseFacturation;
    }

    public function setAdresseFacturation(?string $adresseFacturation): self
    {
        $this->adresseFacturation = $adresseFacturation;

        return $this;
    }

    /**
     * @return Collection<int, Facture>
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures->add($facture);
            $facture->setCustomer($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getCustomer() === $this) {
                $facture->setCustomer(null);
            }
        }

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }
}
