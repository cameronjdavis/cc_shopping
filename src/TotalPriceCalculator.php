<?php

namespace CodeClanShopping;

/**
 * Calculate the total price for a basket of shopping items
 * without discounting.
 */
class TotalPriceCalculator
{

    /**
     * Calculate the total price for items in a basket
     * without any discounting.
     * @param \CodeClanShopping\ShoppingItemCollection $basket
     * @return float
     */
    public function calculateTotal(ShoppingItemCollection $basket)
    {
        $total = 0.0;

        foreach ($basket->getItems() as $item) {
            $total += $item->getPrice();
        }

        return $total;
    }
}
