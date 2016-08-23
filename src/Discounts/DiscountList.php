<?php

namespace CodeClanShopping\Discounts;

use CodeClanShopping\Discount;

/**
 * An ordered list of discounts that are applied to a total price.
 * This class implements Discount so it can be used
 * wherever a single Discount is used. Interfaces for the win!
 */
class DiscountList extends \ArrayObject implements Discount
{

    /**
     * Add a discount to the list.
     * @param Discount $value
     * @throws \InvalidArgumentException
     * @todo: Need to ensure type checking for all methods of adding an item.
     */
    public function append($value)
    {
        // do a type-check to protect against PHP's loose typing
        if (!$value instanceof Discount) {
            throw new \InvalidArgumentException('Only objects of type ' . Discount::class . ' can be added.');
        }

        return parent::append($value);
    }

    /**
     * Apply each discount to the total.
     * @param float $total Total before discounting.
     * @return float Discounted total.
     */
    public function applyDiscount($total)
    {
        // apply each discount in order
        foreach ($this as $discount) {
            $total = $discount->applyDiscount($total);
        }

        return $total;
    }
}
