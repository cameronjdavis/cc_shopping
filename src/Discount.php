<?php

namespace CodeClanShopping;

/**
 * A class implenting this interface can calculate and
 * apply a discount to a total price.
 */
interface Discount
{
    /**
     * Apply a discount to a total price.
     * @param float $total Total price before discount.
     * @return float Discounted total price.
     */
    public function applyDiscount($total);
}
