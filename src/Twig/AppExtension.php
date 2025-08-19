<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigTest;

class AppExtension extends AbstractExtension
{
    public function getTests(): array
    {
        return [
            new TwigTest('instance_of', $this->isInstanceOf(...)),
            new TwigTest('is_gif_file_format', $this->isGifFileFormat(...)),
        ];
    }

    public function isInstanceOf($var, $instance): bool
    {
        return new \ReflectionClass($instance)->isInstance($var);
    }

    public function isGifFileFormat(Project $filename): bool
    {
        // 1. Fast check: by file extension
        if ('gif' === strtolower(pathinfo($filename, PATHINFO_EXTENSION))) {
            return true;
        }

        // 2. (Optional) Safer check: by mime type if file exists
        if (is_file($filename)) {
            $mime = mime_content_type($filename);

            return 'image/gif' === $mime;
        }

        return false;
    }
}
