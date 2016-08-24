<?php

namespace CodeClanShopping\Discounts;

use CodeClanShopping\Discount;

/**
 * A discount that is applied if the total meets a threshold amount.
 */
class TotalThresholdDiscount implements Discount
{
    /**
     * Minimum threshold for total to be greater-than or equal to.
     * @var float
     */
    private $threshold;

    /**
     * Discount to apply if total price meets threshold.
     * @var Discount
     */
    private $discount;

    /**
     * @param float $threshold Threshold to be met for discount.
     * @param Discount $discount To be applied if threshold is met.
     */
    public function __construct($threshold, Discount $discount)
    {
        $this->threshold = $threshold;
        $this->discount = $discount;
    }

    /**
     * Apply the discount if $total meets the threshold.
     * @param float $total Total price before discounting.
     * @return float Optionally discounted total price.
     */
    public function applyDiscount($total)
    {
        // if the total meets the minimum threshold
        if ($total >= $this->threshold) {
            return $this->discount->applyDiscount($total);
        }

        // total is not above threshold so do not apply discount
        return $total;
    }
}
