<?php

namespace App\Entity;

use App\Repository\TOrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TOrderRepository::class)]
class TOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $ordDate = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $ordPrice = null;

    #[ORM\ManyToOne(inversedBy: 'tOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?tstatus $idxStatus = null;

    #[ORM\ManyToOne(inversedBy: 'tOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?taddress $idxAddress = null;

    #[ORM\ManyToOne(inversedBy: 'tOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?tuser $idxUser = null;

    #[ORM\ManyToOne(inversedBy: 'torders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ttime $idxTime = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrdDate(): ?\DateTimeInterface
    {
        return $this->ordDate;
    }

    public function setOrdDate(\DateTimeInterface $ordDate): self
    {
        $this->ordDate = $ordDate;

        return $this;
    }

    public function getOrdPrice(): ?int
    {
        return $this->ordPrice;
    }

    public function setOrdPrice(int $ordPrice): self
    {
        $this->ordPrice = $ordPrice;

        return $this;
    }

    public function getIdxStatus(): ?tstatus
    {
        return $this->idxStatus;
    }

    public function setIdxStatus(?tstatus $idxStatus): self
    {
        $this->idxStatus = $idxStatus;

        return $this;
    }

    public function getIdxAddress(): ?taddress
    {
        return $this->idxAddress;
    }

    public function setIdxAddress(?taddress $idxAddress): self
    {
        $this->idxAddress = $idxAddress;

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

    public function getIdxTime(): ?ttime
    {
        return $this->idxTime;
    }

    public function setIdxTime(?ttime $idxTime): self
    {
        $this->idxTime = $idxTime;

        return $this;
    }
}
