<?php

namespace App\Entity;

use App\Repository\TTitleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TTitleRepository::class)]
class TTitle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10)]
    private ?string $titName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitName(): ?string
    {
        return $this->titName;
    }

    public function setTitName(string $titName): self
    {
        $this->titName = $titName;

        return $this;
    }
}
