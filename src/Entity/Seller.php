<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\LoginController;
use App\Repository\SellerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use App\State\SellerProcessor;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SellerRepository::class)]
#[ApiResource(
    security:"is_granted('ROLE_USER')",
    operations:[
        new GetCollection(security:"is_granted('ROLE_ADMIN')"),
        new Get(security:"is_granted('ROLE_ADMIN') and object.owner == user"),
        new Put(processor: SellerProcessor::class),
        new Patch(processor:SellerProcessor::class),
        new Post(processor:SellerProcessor::class),
        new Delete(),
        new Post(
            controller:LoginController::class,
            routeName: 'check_login',
            uriTemplate: 'api/login',
            denormalizationContext: ['groups'=>['login:seller:data']],
            normalizationContext:['groups'=>['read:seller:data']],
            options: ['descriotion'=>'login the user'],
            description:'loggin the user',
            shortName:'Login user',
        )
    ]
)]
#[ApiFilter(SearchFilter::class,properties:[
    'id'=>'exact',
    'denomination'=>'partial',
    'nom'=> 'partial',
    'prenom'=> 'partial',
    'email'=> 'exact'
    ])
]
class Seller implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('read:seller:data')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('read:seller:data')]
    private ?string $denomination = null;

    #[ORM\Column(length: 255)]
    #[Groups('read:seller:data')]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('read:seller:data')]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Groups('read:seller:data')]
    private ?string $adresseSiege = null;

    #[ORM\Column(length: 255)]
    #[Groups('read:seller:data')]
    private ?string $adresseFacturation = null;

    #[ORM\Column(type: 'string',length: 255, unique: true)]
    #[Groups(['read:seller:data','login:seller:data'])]
    private ?string $email = null;

    #[ORM\Column(type: 'json')]
    #[Groups('read:seller:data')]
    private $roles = [];

    #[ORM\Column(type:'string',length: 255)]
    #[Groups('login:seller:data')]
    private ?string $motDePasse = null;

    #[ORM\Column(length: 255)]
    #[Groups('read:seller:data')]
    private ?string $codePostale = null;

    #[ORM\Column(length: 255)]
    #[Groups('read:seller:data')]
    private ?string $ville = null;

    #[ORM\Column(length: 9)]
    #[Groups('read:seller:data')]
    private ?string $siren = null;

    #[ORM\Column(length: 14)]
    #[Groups('read:seller:data')]
    private ?string $siret = null;

    #[ORM\Column(length: 255)]
    #[Groups('read:seller:data')]
    private ?string $rcs = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups('read:seller:data')]
    private ?string $logo = null;

    #[ORM\OneToMany(mappedBy: 'seller', targetEntity: Facture::class, orphanRemoval: true)]
    private Collection $factures;

    #[ORM\Column]
    #[Groups('read:seller:data')]
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

    public function setNom(string $nom): self
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

    public function getAdresseSiege(): ?string
    {
        return $this->adresseSiege;
    }

    public function setAdresseSiege(string $adresseSiege): self
    {
        $this->adresseSiege = $adresseSiege;

        return $this;
    }

    public function getAdresseFacturation(): ?string
    {
        return $this->adresseFacturation;
    }

    public function setAdresseFacturation(string $adresseFacturation): self
    {
        $this->adresseFacturation = $adresseFacturation;

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

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getCodePostale(): ?string
    {
        return $this->codePostale;
    }

    public function setCodePostale(string $codePostale): self
    {
        $this->codePostale = $codePostale;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getSiren(): ?string
    {
        return $this->siren;
    }

    public function setSiren(string $siren): self
    {
        $this->siren = $siren;

        return $this;
    }

    public function getSiret(): ?string
    {
        return $this->siret;
    }

    public function setSiret(string $siret): self
    {
        $this->siret = $siret;

        return $this;
    }

    public function getRcs(): ?string
    {
        return $this->rcs;
    }

    public function setRcs(string $rcs): self
    {
        $this->rcs = $rcs;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

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
            $facture->setSeller($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->removeElement($facture)) {
            // set the owning side to null (unless already changed)
            if ($facture->getSeller() === $this) {
                $facture->setSeller(null);
            }
        }

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
	/**
	 * Returns the roles granted to the user.
	 *
	 * public function getRoles()
	 * {
	 * return ['ROLE_USER'];
	 * }
	 *
	 * Alternatively, the roles might be stored in a ``roles`` property,
	 * and populated in any number of different ways when the user object
	 * is created.
	 * @return array<string>
	 */
	public function getRoles(): array {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
	}

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
	/**
	 * Removes sensitive data from the user.
	 *
	 * This is important if, at any given point, sensitive information like
	 * the plain-text password is stored on this object.
	 * @return mixed
	 */
	public function eraseCredentials() {
	}

	/**
	 * Returns the identifier for this user (e.g. username or email address).
	 * @return string
	 */
	public function getUserIdentifier(): string {
        return $this->email;
	}
	/**
	 * Returns the hashed password used to authenticate the user.
	 *
	 * Usually on authentication, a plain-text password will be compared to this value.
	 * @return null|string
	 */
	public function getPassword(): ?string {
        return (string) $this->motDePasse;
	}
    public function setPassword(string $password): self
    {
        $this->motDePasse = $password;

        return $this;
    }
}
