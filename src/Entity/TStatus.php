<?php

namespace App\Entity;

use App\Repository\TStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TStatusRepository::class)]
class TStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $staName = null;

    #[ORM\OneToMany(mappedBy: 'idxStatus', targetEntity: TOrder::class)]
    private Collection $tOrders;

    public function __construct()
    {
        $this->tOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStaName(): ?string
    {
        return $this->staName;
    }

    public function setStaName(string $staName): self
    {
        $this->staName = $staName;

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
            $tOrder->setIdxStatus($this);
        }

        return $this;
    }

    public function removeTOrder(TOrder $tOrder): self
    {
        if ($this->tOrders->removeElement($tOrder)) {
            // set the owning side to null (unless already changed)
            if ($tOrder->getIdxStatus() === $this) {
                $tOrder->setIdxStatus(null);
            }
        }

        return $this;
    }
}
