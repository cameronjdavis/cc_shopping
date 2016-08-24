<?php

namespace CodeClanShopping\Test;

use CodeClanShopping\Basket;
use CodeClanShopping\ShoppingItem;
use CodeClanShopping\TotalPriceCalculator;
use CodeClanShopping\Discounts\PercentageDiscount;
use CodeClanShopping\Discounts\LoyaltyDiscount;
use CodeClanShopping\Discounts\TotalThresholdDiscount;
use CodeClanShopping\Rounding;
use CodeClanShopping\Discounts\TwoForOneDiscount;
use CodeClanShopping\ShoppingItemSet;

/**
 * This is not a unit test, rather it demonstrates the classes
 * as they would be used in production.
 */
class RealWorldTest extends \PHPUnit_Framework_TestCase
{

    public function test_1()
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
        $basket->addItem($item1);
        $basket->addItem($item1);
        $basket->addItem($item1);
        $basket->addItem($item1);
        $basket->addItem($item1);
        
        $basket->addItem($item1);
        $basket->addItem($item1);
        $basket->addItem($item1);
        $basket->addItem($item1);
        $basket->addItem($item1);
        
        // add item 2
        $basket->addItem($item2);
        $basket->addItem($item2);
        $basket->addItem($item2);
        $basket->addItem($item2);
        $basket->addItem($item2);
        
        $basket->addItem($item2);
        $basket->addItem($item2);
        $basket->addItem($item2);
        
        // add item 3, which is two-for-one
        $basket->addItem($item3);
        $basket->addItem($item3);

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
        $thresholdDiscount = new TotalThresholdDiscount(20.0, $percentageDiscount1);
        $total2 = $thresholdDiscount->applyDiscount($total1);
        $this->assertEquals($total1 * (1 - 0.1), $total2);
        
        // add a loyalty card discount of 2%
        $percentageDiscount2 = new PercentageDiscount(0.02);
        $loyaltyDiscount = new LoyaltyDiscount($isLoyal, $percentageDiscount2);
        $total3 = $loyaltyDiscount->applyDiscount($total2);
        $this->assertEquals($total2 * (1 - 0.02), $total3);
        
        // round (read truncate) the final discounted price
        $rounding = new Rounding();
        $roundedTotal = $rounding->roundPrice($total3);
        $this->assertEquals(31.91, $roundedTotal);
    }
}
