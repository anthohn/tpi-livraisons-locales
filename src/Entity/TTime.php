<?php

namespace App\Entity;

use App\Repository\TTimeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TTimeRepository::class)]
class TTime
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $timSlice = null;

    #[ORM\OneToMany(mappedBy: 'idxTime', targetEntity: Torder::class)]
    private Collection $torders;

    public function __construct()
    {
        $this->torders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimSlice(): ?string
    {
        return $this->timSlice;
    }

    public function setTimSlice(string $timSlice): self
    {
        $this->timSlice = $timSlice;

        return $this;
    }

    /**
     * @return Collection<int, Torder>
     */
    public function getTorders(): Collection
    {
        return $this->torders;
    }

    public function addTorder(Torder $torder): self
    {
        if (!$this->torders->contains($torder)) {
            $this->torders->add($torder);
            $torder->setIdxTime($this);
        }

        return $this;
    }

    public function removeTorder(Torder $torder): self
    {
        if ($this->torders->removeElement($torder)) {
            // set the owning side to null (unless already changed)
            if ($torder->getIdxTime() === $this) {
                $torder->setIdxTime(null);
            }
        }

        return $this;
    }
}
