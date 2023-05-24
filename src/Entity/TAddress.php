<?php

namespace App\Entity;

use App\Repository\TAddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TAddressRepository::class)]
class TAddress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $addAddress = null;

    #[ORM\Column(length: 20)]
    private ?string $addCity = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $addPc = null;

    #[ORM\Column(length: 25)]
    private ?string $addCountry = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $addLatitude = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $addLongitude = null;

    #[ORM\ManyToOne(inversedBy: 'tAddresses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?tuser $idxUser = null;

    #[ORM\OneToMany(mappedBy: 'idxAddress', targetEntity: TOrder::class)]
    private Collection $tOrders;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TTitle $idxTitle = null;

    #[ORM\Column(length: 20)]
    private ?string $addFirstName = null;

    #[ORM\Column(length: 20)]
    private ?string $addLastName = null;

    public function __construct()
    {
        $this->tOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddAddress(): ?string
    {
        return $this->addAddress;
    }

    public function setAddAddress(string $addAddress): self
    {
        $this->addAddress = $addAddress;

        return $this;
    }

    public function getAddCity(): ?string
    {
        return $this->addCity;
    }

    public function setAddCity(string $addCity): self
    {
        $this->addCity = $addCity;

        return $this;
    }

    public function getAddPc(): ?int
    {
        return $this->addPc;
    }

    public function setAddPc(int $addPc): self
    {
        $this->addPc = $addPc;

        return $this;
    }

    public function getAddCountry(): ?string
    {
        return $this->addCountry;
    }

    public function setAddCountry(string $addCountry): self
    {
        $this->addCountry = $addCountry;

        return $this;
    }

    public function getAddLatitude(): ?string
    {
        return $this->addLatitude;
    }

    public function setAddLatitude(string $addLatitude): self
    {
        $this->addLatitude = $addLatitude;

        return $this;
    }

    public function getAddLongitude(): ?string
    {
        return $this->addLongitude;
    }

    public function setAddLongitude(string $addLongitude): self
    {
        $this->addLongitude = $addLongitude;

        return $this;
    }

    public function getIdxUser(): ?tuser
    {
        return $this->idxUser;
    }

    public function setIdxUser(?tuser $idxUser): self
    {
        $this->idxUser = $idxUser;

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
            $tOrder->setIdxAddress($this);
        }

        return $this;
    }

    public function removeTOrder(TOrder $tOrder): self
    {
        if ($this->tOrders->removeElement($tOrder)) {
            // set the owning side to null (unless already changed)
            if ($tOrder->getIdxAddress() === $this) {
                $tOrder->setIdxAddress(null);
            }
        }

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

    public function getAddFirstName(): ?string
    {
        return $this->addFirstName;
    }

    public function setAddFirstName(string $addFirstName): self
    {
        $this->addFirstName = $addFirstName;

        return $this;
    }

    public function getAddLastName(): ?string
    {
        return $this->addLastName;
    }

    public function setAddLastName(string $addLastName): self
    {
        $this->addLastName = $addLastName;

        return $this;
    }
}
