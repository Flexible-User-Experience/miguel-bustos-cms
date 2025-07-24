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
        ];
    }

    public function isInstanceOf($var, $instance): bool
    {
        return new \ReflectionClass($instance)->isInstance($var);
    }
}