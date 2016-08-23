<?php

namespace CodeClanShopping\Discounts;

use CodeClanShopping\Discount;
use CodeClanShopping\Basket;

class TwoForOneDiscount implements Discount
{
    /**
     * List of PLUs that are being sold as two-for-one.
     * @var string[]
     */
    private $pluList;

    /**
     * Basket the discount will be applied to.
     * @var Basket
     */
    private $basket;

    public function __construct($pluList, Basket $basket)
    {
        $this->pluList = $pluList;
        $this->basket = $basket;
    }

    /**
     * Look for items in $this->basket that have a two-for-one
     * discount, then calulcate and deduct the discount from
     * the total basket price.
     * @param float $total Total befor discounting.
     * @return float Discounted total.
     */
    public function applyDiscount($total)
    {
        // for each PLU that has a two-for-one offer
        foreach ($this->pluList as $plu) {
            $numItems = 0;

            // count the items in the basket with this PLU
            foreach ($this->basket->getContents() as $item) {
                if ($item->getPlu() == $plu) {
                    $numItems++;
                }
            }

            // calcaulate the discount for the items that have this PLU
            $discount = $this->calculateDiscount($numItems, $item->getPrice());
            // subtract the discount for this PLU
            $total = $total - $discount;
        }

        return $total;
    }

    /**
     * Calculate the dollar value of a two-for-one discount for
     * an arbitrary number of items given their unit price.
     * The two-for-one discount value is equal to the number of items,
     * floored to the next integer down,
     * and multiplied by the unit price.
     * @param integer $numItems
     * @param float $unitPrice
     * @return float
     */
    public function calculateDiscount($numItems, $unitPrice)
    {
        return floor($numItems / 2) * $unitPrice;
    }
}
