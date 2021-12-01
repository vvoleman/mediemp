<?php

namespace App\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class InstanceOfExtension extends AbstractExtension {

    public function getFunctions(): array {
        return [
            new TwigFunction('instanceof', [$this, 'isInstanceOf']),
        ];
    }

    public function isInstanceOf($var, $instance) {
        dd($var);
        $reflexionClass = new \ReflectionClass($instance);
        return $reflexionClass->isInstance($var);
    }

}