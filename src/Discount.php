<?php

namespace CodeClanShopping;

interface Discount
{
    /**
     * Apply a discount to a total price.
     * @param float $total Total price before discount.
     * @return float Discounted total price.
     */
    public function applyDiscount($total);
}
