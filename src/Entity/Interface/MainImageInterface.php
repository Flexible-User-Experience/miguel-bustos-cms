<?php

namespace App\Entity\Interface;

use Symfony\Component\HttpFoundation\File\File;

interface MainImageInterface
{
    public function getMainImage(): ?string;

    public function setMainImage(?string $mainImage): self;

    public function getPosition(): int;

    public function setPosition(int $position): self;

    public function getMainImageFile(): ?File;

    public function setMainImageFile(?File $mainImageFile): self;
}
