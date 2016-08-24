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
     * @param \CodeClanShopping\Basket $basket
     * @return float
     */
    public function calculateTotal(Basket $basket)
    {
        $total = 0.0;

        foreach ($basket->getContents() as $item) {
            $total += $item->getPrice();
        }

        return $total;
    }
}
