<?php

namespace App\Twig;

use App\Entity\Interface\ImageInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

class AppExtension extends AbstractExtension
{
    public function getTests(): array
    {
        return [
            new TwigTest('instance_of', $this->isInstanceOf(...)),
            new TwigTest('gif_file_format', $this->isGifFileFormat(...)),
        ];
    }

    public function isInstanceOf($var, $instance): bool
    {
        return new \ReflectionClass($instance)->isInstance($var);
    }

    public function isGifFileFormat(ImageInterface $image): bool
    {
        if ('image/gif' === strtolower($image->getMimeType() ?: '')) {
            return true;
        }
        if ('gif' === strtolower(pathinfo($image->getOriginalName() ?: '', PATHINFO_EXTENSION))) {
            return true;
        }

        return false;
    }
}
