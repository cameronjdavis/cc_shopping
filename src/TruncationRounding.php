<?php

namespace CodeClanShopping;

/**
 * Rounds (read truncate) prices in the customer's favour.
 */
class TruncationRounding implements Rounding
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
