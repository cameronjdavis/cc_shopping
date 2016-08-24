<?php

namespace CodeClanShopping;

/**
 * A Rounding class defines a method for rounding prices.
 */
interface Rounding
{

    /**
     * Round and return a price.
     * @param float $price To be rounded.
     * @return float Rounded price.
     */
    public function roundPrice($price);
}
