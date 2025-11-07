<?php

namespace App\Entity\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

trait AwardImageTrait
{
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $awardImage = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    protected ?int $awardSize = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $awardMimeType = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $awardOriginalName = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    protected ?array $awardDimensions = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $awardImage2 = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    protected ?int $awardSize2 = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $awardMimeType2 = null;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $awardOriginalName2 = null;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    protected ?array $awardDimensions2 = null;

    public function getAwardImage(): ?string
    {
        return $this->awardImage;
    }

    public function setAwardImage(?string $image): self
    {
        $this->awardImage = $image;

        return $this;
    }

    public function getAwardSize(): ?int
    {
        return $this->awardSize;
    }

    public function setAwardSize(?int $size): void
    {
        $this->awardSize = $size;
    }

    public function getAwardMimeType(): ?string
    {
        return $this->awardMimeType;
    }

    public function setAwardMimeType(?string $mimeType): void
    {
        $this->awardMimeType = $mimeType;
    }

    public function getAwardOriginalName(): ?string
    {
        return $this->awardOriginalName;
    }

    public function setAwardOriginalName(?string $originalName): void
    {
        $this->awardOriginalName = $originalName;
    }

    public function getAwardDimensions(): ?array
    {
        return $this->awardDimensions;
    }

    public function setAwardDimensions(?array $dimensions): void
    {
        $this->awardDimensions = $dimensions;
    }

    public function getAwardImageFile(): ?File
    {
        return $this->awardImageFile;
    }

    public function setAwardImageFile(?File $imageFile): self
    {
        $this->awardImageFile = $imageFile;
        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    public function getAwardImage2(): ?string
    {
        return $this->awardImage2;
    }

    public function setAwardImage2(?string $image): self
    {
        $this->awardImage2 = $image;

        return $this;
    }

    public function getAwardSize2(): ?int
    {
        return $this->awardSize2;
    }

    public function setAwardSize2(?int $size): void
    {
        $this->awardSize2 = $size;
    }

    public function getAwardMimeType2(): ?string
    {
        return $this->awardMimeType2;
    }

    public function setAwardMimeType2(?string $mimeType): void
    {
        $this->awardMimeType2 = $mimeType;
    }

    public function getAwardOriginalName2(): ?string
    {
        return $this->awardOriginalName2;
    }

    public function setAwardOriginalName2(?string $originalName): void
    {
        $this->awardOriginalName2 = $originalName;
    }

    public function getAwardDimensions2(): ?array
    {
        return $this->awardDimensions2;
    }

    public function setAwardDimensions2(?array $dimensions): void
    {
        $this->awardDimensions2 = $dimensions;
    }

    public function getAwardImageFile2(): ?File
    {
        return $this->awardImageFile2;
    }

    public function setAwardImageFile2(?File $imageFile): self
    {
        $this->awardImageFile2 = $imageFile;
        if (null !== $imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }
}
