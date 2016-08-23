<?php

namespace CodeClanShopping\Test;

use CodeClanShopping\Basket;
use CodeClanShopping\ShoppingItem;
use CodeClanShopping\TotalPriceCalculator;
use CodeClanShopping\Discounts\DiscountList;
use CodeClanShopping\Discounts\PercentageDiscount;
use CodeClanShopping\Discounts\LoyaltyDiscount;
use CodeClanShopping\Discounts\TotalThresholdDiscount;
use CodeClanShopping\Rounding;

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

        // put some items in the basket
        $item1 = new ShoppingItem('PLU 1', 'Name 1', 1.09);
        $item2 = new ShoppingItem('PLU 2', 'Name 2', 2.77);
        
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

        // caluclate the total before discounting
        $calculator = new TotalPriceCalculator();
        $total = $calculator->calculateTotal($basket);
        $this->assertEquals(33.06, $total);

        // create a list of discounts
        $discounts = new DiscountList();
        
        // add a total threshold discount for 10% after £20 total
        $percentageDiscount1 = new PercentageDiscount(0.1);
        $discounts->append(new TotalThresholdDiscount(20.0, $percentageDiscount1));
        
        // add a loyalty card discount 0f 2%
        $percentageDiscount2 = new PercentageDiscount(0.02);
        $discounts->append(new LoyaltyDiscount($isLoyal, $percentageDiscount2));
        
        // apply the list of discounts to the total
        $discountedTotal = $discounts->applyDiscount($total);
        $this->assertEquals(29.15892, $discountedTotal);
        
        // round (read truncate) the final discounted price
        $rounding = new Rounding();
        $roundedTotal = $rounding->roundPrice($discountedTotal);
        $this->assertEquals(29.15, $roundedTotal);
    }
}
