<?php

namespace CodeClanShopping\Discounts;

use CodeClanShopping\Discount;

class PercentageDiscount implements Discount
{
    private $percentage;

    /**
     * @param float $percentage E.g. 0.15 = 15% discount.
     */
    public function __construct($percentage)
    {
        $this->percentage = $percentage;
    }

    /**
     * Apply a percentage discount to $total.
     * @param float $total Total before discounting.
     * @return float Discounted total.
     */
    public function applyDiscount($total)
    {
        return $total * (1.0 - $this->percentage);
    }
}
