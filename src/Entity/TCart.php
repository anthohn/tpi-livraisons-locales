<?php

namespace App\Entity;

use App\Repository\TCartRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TCartRepository::class)]
class TCart
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?TProduct $idxProduct = null;

    #[ORM\ManyToOne(inversedBy: 'tCarts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?tUser $idxUser = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $carAddedDate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdxProduct(): ?tProduct
    {
        return $this->idxProduct;
    }

    public function setIdxProduct(?tProduct $idxProduct): self
    {
        $this->idxProduct = $idxProduct;

        return $this;
    }

    public function getIdxUser(): ?tUser
    {
        return $this->idxUser;
    }

    public function setIdxUser(?tUser $idxUser): self
    {
        $this->idxUser = $idxUser;

        return $this;
    }

    public function getCarAddedDate(): ?\DateTimeInterface
    {
        return $this->carAddedDate;
    }

    public function setCarAddedDate(\DateTimeInterface $carAddedDate): self
    {
        $this->carAddedDate = $carAddedDate;

        return $this;
    }
}
