<?php

namespace App\Interface;

interface SlugInterface
{
    public function getSlug(): string;
    public function setSlug(string $slug): self;
}
