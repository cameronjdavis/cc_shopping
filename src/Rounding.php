<?php

namespace CodeClanShopping;

/**
 * This class is the central authority for rounding prices.
 * Prices are rounded (read truncated) in the customer's favour.
 */
class Rounding
{

    /**
     * Round a price to two decimal places.
     * It's not true rounding, it's truncating in the customer's favour.
     * @param float $price
     * @return float
     */
    public function roundPrice($price)
    {
        return floor($price * 100) / 100;
    }
}
