<?php

namespace App\Entity\Interface;

use Symfony\Component\HttpFoundation\File\File;

interface ImageInterface
{
    public function getMainImage(): ?string;

    public function setMainImage(?string $mainImage): self;

    public function getSize(): ?int;

    public function setSize(?int $size): void;

    public function getMimeType(): ?string;

    public function setMimeType(?string $mimeType): void;

    public function getOriginalName(): ?string;

    public function setOriginalName(?string $originalName): void;

    public function getDimensions(): ?array;

    public function setDimensions(?array $dimensions): void;

    public function getPosition(): int;

    public function setPosition(int $position): self;

    public function getMainImageFile(): ?File;

    public function setMainImageFile(?File $mainImageFile): self;
}
