<?php

namespace CodeClanShopping\Test;

use CodeClanShopping\Basket;
use CodeClanShopping\ShoppingItem;
use CodeClanShopping\TotalPriceCalculator;
use CodeClanShopping\Discounts\PercentageDiscount;
use CodeClanShopping\Discounts\LoyaltyDiscount;
use CodeClanShopping\Discounts\TotalThresholdDiscount;
use CodeClanShopping\TruncationRounding;
use CodeClanShopping\Discounts\TwoForOneDiscount;
use CodeClanShopping\ShoppingItemSet;
use CodeClanShopping\Discounts\DiscountList;

/**
 * This is not a unit test, rather it demonstrates the classes
 * as they would be used in production.
 */
class RealWorldTest extends \PHPUnit_Framework_TestCase
{

    /**
     * An empty basket and using DiscountList.
     */
    public function test_discountList()
    {
        // simulated input for loyalty card
        $isLoyal = true;

        // create a new basket
        $basket = new Basket();

        // create an item for discounting
        $item3 = new ShoppingItem('PLU 3', 'Name 3', 3.12);

        // calculate the total before discounting
        $calculator = new TotalPriceCalculator();
        $total = $calculator->calculateTotal($basket);

        // create a list of discounts
        $discountList = new DiscountList();

        // add a two-for-one discount which is first in line
        $discountedItems = new ShoppingItemSet();
        $discountedItems->add($item3);
        $discountList->append(new TwoForOneDiscount($discountedItems, $basket));

        // add a total threshold discount for 10% after £20 total
        $percentageDiscount1 = new PercentageDiscount(0.1);
        $discountList->append(new TotalThresholdDiscount(20.0,
                $percentageDiscount1));

        // add a loyalty card discount of 2%
        $percentageDiscount2 = new PercentageDiscount(0.02);
        $discountList->append(new LoyaltyDiscount($isLoyal, $percentageDiscount2));

        // apply all the discounts in order
        $discountedTotal = $discountList->applyDiscount($total);
        
        // round (read truncate) the final discounted price
        $rounding = new TruncationRounding();
        $roundedTotal = $rounding->roundPrice($discountedTotal);
        
        $this->assertSame(0.0, $roundedTotal);
    }

    /**
     * Process a basket with lots of items and doing discounting step by step.
     */
    public function test_filledBasket()
    {
        // simulated input for loyalty card
        $isLoyal = true;

        // create a new basket
        $basket = new Basket();

        // create some items for purchasing
        $item1 = new ShoppingItem('PLU 1', 'Name 1', 1.09);
        $item2 = new ShoppingItem('PLU 2', 'Name 2', 2.77);
        $item3 = new ShoppingItem('PLU 3', 'Name 3', 3.12);

        // add item 1
        $basket->add($item1);
        $basket->add($item1);
        $basket->add($item1);
        $basket->add($item1);
        $basket->add($item1);

        $basket->add($item1);
        $basket->add($item1);
        $basket->add($item1);
        $basket->add($item1);
        $basket->add($item1);

        // add item 2
        $basket->add($item2);
        $basket->add($item2);
        $basket->add($item2);
        $basket->add($item2);
        $basket->add($item2);

        $basket->add($item2);
        $basket->add($item2);
        $basket->add($item2);

        // add item 3, which is two-for-one
        $basket->add($item3);
        $basket->add($item3);

        // calculate the total before discounting
        $calculator = new TotalPriceCalculator();
        $total = $calculator->calculateTotal($basket);
        $this->assertEquals(39.30, $total);

        // add a two-for-one discount which is first in line
        $discountedItems = new ShoppingItemSet();
        $discountedItems->add($item3);
        $twoForOneDiscount = new TwoForOneDiscount($discountedItems, $basket);
        $total1 = $twoForOneDiscount->applyDiscount($total);
        $this->assertEquals($total - 3.12, $total1);

        // add a total threshold discount for 10% after £20 total
        $percentageDiscount1 = new PercentageDiscount(0.1);
        $thresholdDiscount = new TotalThresholdDiscount(20.0,
                $percentageDiscount1);
        $total2 = $thresholdDiscount->applyDiscount($total1);
        $this->assertEquals($total1 * (1 - 0.1), $total2);

        // add a loyalty card discount of 2%
        $percentageDiscount2 = new PercentageDiscount(0.02);
        $loyaltyDiscount = new LoyaltyDiscount($isLoyal, $percentageDiscount2);
        $total3 = $loyaltyDiscount->applyDiscount($total2);
        $this->assertEquals($total2 * (1 - 0.02), $total3);

        // round (read truncate) the final discounted price
        $rounding = new TruncationRounding();
        $roundedTotal = $rounding->roundPrice($total3);
        $this->assertEquals(31.91, $roundedTotal);
    }
}
