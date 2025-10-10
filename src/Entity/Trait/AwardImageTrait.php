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

    public function getAwardImage(): ?string
    {
        return $this->awardImage;
    }

    public function setAwardImage(?string $mainImage): self
    {
        $this->awardImage = $mainImage;

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

    public function setAwardImageFile(?File $awardImageFile): self
    {
        $this->awardImageFile = $awardImageFile;
        if (null !== $awardImageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }
}
