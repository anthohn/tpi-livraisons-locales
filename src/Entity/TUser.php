<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TUserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: TUserRepository::class)]
#[UniqueEntity(fields: "useEmail", message: "L'email que vous avez indiqué est déjà utilisé !")]
class TUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\NotBlank(message:"Champ requis")]
    #[Assert\Email(message: "Le champ doit contenir une adresse e-mail valide")]
    private ?string $useEmail = null;

    /**
     * @var string The hashed password
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Champ requis")]
    #[Assert\Length(min: 8, max: 255, minMessage: 'Votre mot de passe doit faire minimum 8 caractères')]
    private ?string $password = null;

    #[Assert\EqualTo(propertyPath:"password", message:"Vous n'avez pas tapé le même mot de passe")]
    public $password_confirm;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message:"Champ requis")]
    private ?string $useFirstName = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message:"Champ requis")]
    private ?string $useLastName = null;

    #[ORM\Column]
    private array $useRoles = [];

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $useCreatedDate = null;

    #[ORM\OneToMany(mappedBy: 'idxUser', targetEntity: TCart::class, orphanRemoval: true)]
    private Collection $tCarts;

    #[ORM\OneToMany(mappedBy: 'idxUser', targetEntity: TAddress::class, orphanRemoval: true)]
    private Collection $tAddresses;

    #[ORM\OneToMany(mappedBy: 'idxUser', targetEntity: TOrder::class, orphanRemoval: true)]
    private Collection $tOrders;

    public function __construct()
    {
        $this->tCarts = new ArrayCollection();
        $this->tAddresses = new ArrayCollection();
        $this->tOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUseEmail(): ?string
    {
        return $this->useEmail;
    }

    public function setUseEmail(string $useEmail): self
    {
        $this->useEmail = $useEmail;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->useEmail;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $useRoles = $this->useRoles;
        // guarantee every user at least has ROLE_USER
        $useRoles[] = 'ROLE_USER';

        return array_unique($useRoles);
    }

    public function setRoles(array $useRoles): self
    {
        $this->useRoles = $useRoles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUseFirstName(): ?string
    {
        return $this->useFirstName;
    }

    public function setUseFirstName(string $useFirstName): self
    {
        $this->useFirstName = $useFirstName;

        return $this;
    }

    public function getUseLastName(): ?string
    {
        return $this->useLastName;
    }

    public function setUseLastName(string $useLastName): self
    {
        $this->useLastName = $useLastName;

        return $this;
    }

    public function getUseCreatedDate(): ?\DateTimeInterface
    {
        return $this->useCreatedDate;
    }

    public function setUseCreatedDate(\DateTimeInterface $useCreatedDate): self
    {
        $this->useCreatedDate = $useCreatedDate;

        return $this;
    }

    /**
     * @return Collection<int, TCart>
     */
    public function getTCarts(): Collection
    {
        return $this->tCarts;
    }

    public function addTCart(TCart $tCart): self
    {
        if (!$this->tCarts->contains($tCart)) {
            $this->tCarts->add($tCart);
            $tCart->setIdxUser($this);
        }

        return $this;
    }

    public function removeTCart(TCart $tCart): self
    {
        if ($this->tCarts->removeElement($tCart)) {
            // set the owning side to null (unless already changed)
            if ($tCart->getIdxUser() === $this) {
                $tCart->setIdxUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TAddress>
     */
    public function getTAddresses(): Collection
    {
        return $this->tAddresses;
    }

    public function addTAddress(TAddress $tAddress): self
    {
        if (!$this->tAddresses->contains($tAddress)) {
            $this->tAddresses->add($tAddress);
            $tAddress->setIdxUser($this);
        }

        return $this;
    }

    public function removeTAddress(TAddress $tAddress): self
    {
        if ($this->tAddresses->removeElement($tAddress)) {
            // set the owning side to null (unless already changed)
            if ($tAddress->getIdxUser() === $this) {
                $tAddress->setIdxUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TOrder>
     */
    public function getTOrders(): Collection
    {
        return $this->tOrders;
    }

    public function addTOrder(TOrder $tOrder): self
    {
        if (!$this->tOrders->contains($tOrder)) {
            $this->tOrders->add($tOrder);
            $tOrder->setIdxUser($this);
        }

        return $this;
    }

    public function removeTOrder(TOrder $tOrder): self
    {
        if ($this->tOrders->removeElement($tOrder)) {
            // set the owning side to null (unless already changed)
            if ($tOrder->getIdxUser() === $this) {
                $tOrder->setIdxUser(null);
            }
        }

        return $this;
    }

    public function getUseNumberPhone(): ?string
    {
        return $this->useNumberPhone;
    }

    public function setUseNumberPhone(string $useNumberPhone): self
    {
        $this->useNumberPhone = $useNumberPhone;

        return $this;
    }

    public function getIdxTitle(): ?TTitle
    {
        return $this->idxTitle;
    }

    public function setIdxTitle(?TTitle $idxTitle): self
    {
        $this->idxTitle = $idxTitle;

        return $this;
    }
}
