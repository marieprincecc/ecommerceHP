<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class EuroPriceExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            new TwigFilter('euroPrice', [$this, 'formatPrice']),
        ];
    }

    public function formatPrice($value)
    {
        $value = $value / 100;
        $result = number_format($value,2,","," ");
        $result = $result . " €";
        
        return $result;
    }
}
