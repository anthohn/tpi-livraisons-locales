<?php

namespace App\Entity;

use App\Repository\TProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: TProductRepository::class)]
#[Vich\Uploadable]
class TProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $proName = null;

    #[Vich\UploadableField(mapping: 'product_images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $proPrice = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $proQuantity = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $proDescription = null;

    #[ORM\Column]
    private ?bool $proIsActive = null;

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

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
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

    public function isProIsActive(): ?bool
    {
        return $this->proIsActive;
    }

    public function setProIsActive(bool $proIsActive): self
    {
        $this->proIsActive = $proIsActive;

        return $this;
    }
}
