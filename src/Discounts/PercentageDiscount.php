<?php

namespace CodeClanShopping\Discounts;

use CodeClanShopping\Discount;

/**
 * A percentage discount.
 * E.g. Discount total by 15%.
 */
class PercentageDiscount implements Discount
{
    /**
     * @var float
     */
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
