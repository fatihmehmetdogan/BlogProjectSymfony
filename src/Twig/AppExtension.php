<?php


namespace App\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('instanceOf', [$this, 'instanceOf']),
        ];
    }

    public function instanceOf($object, $className): bool
    {
        return (get_class($object) === $className);
    }
}