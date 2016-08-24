<?php

namespace CodeClanShopping\Discounts;

use CodeClanShopping\Discount;
use CodeClanShopping\Basket;
use CodeClanShopping\ShoppingItemSet;

/**
 * This discount searches a basket for items that are offered two-for-one.
 * If it finds those items, it will calculate and apply the discounted value.
 */
class TwoForOneDiscount implements Discount
{
    /**
     * Set of shopping items that have two-for-one discounts.
     * @var ShoppingItemSet
     */
    private $items;

    /**
     * Basket the discount will be applied to.
     * @var Basket
     */
    private $basket;

    /**
     * @param ShoppingItemSet $items Set of shopping items that have two-for-one discounts.
     * @param Basket $basket Basket of items to search.
     */
    public function __construct(ShoppingItemSet $items, Basket $basket)
    {
        $this->items = $items;
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
        foreach ($this->items->getItems() as $discountedItem) {
            $numItems = 0;
            $unitPrice = null;

            // count the items in the basket with this PLU
            foreach ($this->basket->getContents() as $item) {
                if ($item->getPlu() == $discountedItem->getPlu()) {
                    $numItems++;
                    $unitPrice = $item->getPrice();
                }
            }

            // if enough items for a discount were found
            if ($numItems > 1) {
                // calcaulate the discount for the items that have this PLU
                $discount = $this->calculateDiscount($numItems, $unitPrice);
                // subtract the discount for this PLU
                $total = $total - $discount;
            }
        }

        return $total;
    }

    /**
     * Calculate the dollar value of a two-for-one discount for
     * an arbitrary number of items and given their unit price.
     * The two-for-one discount value is equal to the number of items
     * dividied by 2,
     * floored to the next integer down,
     * and multiplied by the unit price.
     * @param integer $numItems Number of items subject to the discount.
     * @param float $unitPrice Unit price of one item.
     * @return float Two-for-one discount value.
     */
    public function calculateDiscount($numItems, $unitPrice)
    {
        return floor($numItems / 2) * $unitPrice;
    }
}
