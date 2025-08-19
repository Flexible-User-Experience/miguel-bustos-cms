<?php

namespace App\Entity\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

trait MainImageTrait
{
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $mainImage = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?int $size = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $mimeType = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $originalName = null;

    #[ORM\Column(type: Types::JSON, length: 255, nullable: true)]
    protected ?array $dimensions = null;

    public function getMainImage(): ?string
    {
        return $this->mainImage;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): void
    {
        $this->size = $size;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(?string $mimeType): void
    {
        $this->mimeType = $mimeType;
    }

    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    public function setOriginalName(?string $originalName): void
    {
        $this->originalName = $originalName;
    }

    public function getDimensions(): ?array
    {
        return $this->dimensions;
    }

    public function setDimensions(?array $dimensions): void
    {
        $this->dimensions = $dimensions;
    }

    public function setMainImage(?string $mainImage): self
    {
        $this->mainImage = $mainImage;

        return $this;
    }

    public function getMainImageFile(): ?File
    {
        return $this->mainImageFile;
    }

    public function setMainImageFile(?File $mainImageFile): self
    {
        $this->mainImageFile = $mainImageFile;
        if (null !== $mainImageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }
}
