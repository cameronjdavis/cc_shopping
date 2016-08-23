<?php

namespace CodeClanShopping\Discounts;

use CodeClanShopping\Discount;

class LoyaltyDiscount implements Discount
{
    /**
     * True if the customer has a loyalty card, otherwise false.
     * @var boolean
     */
    private $isLoyal;

    /**
     * Discount to apply if customer is loyal.
     * @var Discount
     */
    private $discount;

    public function __construct($isLoyal, Discount $discount)
    {
        $this->isLoyal = $isLoyal;
        $this->discount = $discount;
    }

    /**
     * If customer is loyal then apply a discount.
     * If customer is not loyal then do not apply discount.
     * @param float $total Total price before discounting.
     * @return float Optionally discounted total price.
     */
    public function applyDiscount($total)
    {
        // if customer is loyal then apply the discount
        if ($this->isLoyal) {
            return $this->discount->applyDiscount($total);
        }

        // customer is not loyal so do not apply discount
        return $total;
    }
}
