<?php

namespace App\Entity;

use App\Repository\THaveRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: THaveRepository::class)]
class THave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?torder $idxOrder = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?tproduct $idxProduct = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdxOrder(): ?torder
    {
        return $this->idxOrder;
    }

    public function setIdxOrder(?torder $idxOrder): self
    {
        $this->idxOrder = $idxOrder;

        return $this;
    }

    public function getIdxProduct(): ?tproduct
    {
        return $this->idxProduct;
    }

    public function setIdxProduct(?tproduct $idxProduct): self
    {
        $this->idxProduct = $idxProduct;

        return $this;
    }
}
