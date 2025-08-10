<?php

namespace App\Entity\Trait;

use Doctrine\Common\Collections\Collection;

trait TranslationTrait
{
    public function getTranslations(): ?Collection
    {
        return $this->translations;
    }

    public function setTranslations(?Collection $translations): self
    {
        $this->translations = $translations;

        return $this;
    }
}
