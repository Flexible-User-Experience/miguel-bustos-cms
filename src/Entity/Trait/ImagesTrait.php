<?php

namespace App\Entity\Trait;

use App\Entity\Image\AbstractImage;
use Doctrine\Common\Collections\Collection;

trait ImagesTrait
{
    /**
     * @return Collection<int, AbstractImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function setImages(Collection $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function addImage(AbstractImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
        }

        return $this;
    }

    public function removeImage(AbstractImage $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
        }

        return $this;
    }
}
