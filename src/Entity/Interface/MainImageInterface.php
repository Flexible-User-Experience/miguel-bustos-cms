<?php

namespace App\Entity\Interface;

use Symfony\Component\HttpFoundation\File\File;

//interface MainImageInterface extends SeoAlternativeImageTextInterface
interface MainImageInterface
{
    public function getMainImage(): ?string;

    public function setMainImage(?string $mainImage): self;

    public function getMainImageFile(): ?File;

    public function setMainImageFile(?File $mainImageFile): self;
}
