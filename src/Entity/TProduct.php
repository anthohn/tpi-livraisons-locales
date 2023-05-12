<?php

namespace App\Entity;

use App\Repository\TProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TProductRepository::class)]
class TProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $proName = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $proPrice = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $proQuantity = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $proDescription = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProName(): ?string
    {
        return $this->proName;
    }

    public function setProName(string $proName): self
    {
        $this->proName = $proName;

        return $this;
    }

    public function getProPrice(): ?int
    {
        return $this->proPrice;
    }

    public function setProPrice(int $proPrice): self
    {
        $this->proPrice = $proPrice;

        return $this;
    }

    public function getProQuantity(): ?int
    {
        return $this->proQuantity;
    }

    public function setProQuantity(int $proQuantity): self
    {
        $this->proQuantity = $proQuantity;

        return $this;
    }

    public function getProDescription(): ?string
    {
        return $this->proDescription;
    }

    public function setProDescription(string $proDescription): self
    {
        $this->proDescription = $proDescription;

        return $this;
    }
}
