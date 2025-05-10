<?php

namespace App\Entity\Interface;

use Doctrine\Common\Collections\Collection;

interface ImagesInterface
{
    public function getImages(): Collection;

    public function setImages(Collection $images): self;
}
