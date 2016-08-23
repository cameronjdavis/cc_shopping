<?php

namespace CodeClanShopping\Test;

use CodeClanShopping\Basket;
use CodeClanShopping\ShoppingItem;
use CodeClanShopping\TotalPriceCalculator;
use CodeClanShopping\Discounts\DiscountList;
use CodeClanShopping\Discounts\PercentageDiscount;
use CodeClanShopping\Discounts\LoyaltyDiscount;
use CodeClanShopping\Discounts\TotalThresholdDiscount;

/**
 * This is not a unit test, rather it demonstrates the classes
 * as they would be used in production.
 */
class RealWorldTest extends \PHPUnit_Framework_TestCase
{

    public function test_1()
    {
        // create a new basket
        $basket = new Basket();

        // put some items in the basket
        $item1 = new ShoppingItem('PLU 1', 'Name 1', 1.09);
        $item2 = new ShoppingItem('PLU 2', 'Name 2', 2.77);
        $basket->addItem($item1);
        $basket->addItem($item1);
        $basket->addItem($item2);

        // caluclate the total before discounting
        $calculator = new TotalPriceCalculator();
        $total = $calculator->calculateTotal($basket);

        // create a list of discounts
        $discounts = new DiscountList();
        
        // add a total threshold discount for 10% after £20 total
        $percentageDiscount1 = new PercentageDiscount(0.1);
        $discounts->append(new TotalThresholdDiscount(20.0, $percentageDiscount1));
        
        // add a loyalty card discount
        $percentageDiscount2 = new PercentageDiscount(0.02);
        $discounts->append(new LoyaltyDiscount(true, $percentageDiscount2));
        
        // apply the list of discounts to the total
        $discountedTotal = $discounts->applyDiscount($total);
        
        // @todo: check final calculation
        //$this->assertEquals($total * (1 - 0.1) * (1 - 0.02), $discountedTotal);
    }
}
