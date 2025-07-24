<?php

namespace App\Entity\Trait;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

trait MainImageTrait
{
    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $mainImage = null;

    public function getMainImage(): ?string
    {
        return $this->mainImage;
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
