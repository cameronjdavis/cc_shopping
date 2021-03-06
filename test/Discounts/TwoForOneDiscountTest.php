<?php

namespace CodeClanShopping\Test\Discounts;

use CodeClanShopping\Discounts\TwoForOneDiscount as Subject;
use CodeClanShopping\Basket;
use CodeClanShopping\ShoppingItem;
use CodeClanShopping\ShoppingItemSet;

class TwoForOneDiscountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Subject
     */
    private $subject;

    /**
     * @var Basket
     */
    private $basket;
    
    /**
     * @var ShoppingItemSet
     */
    private $items;

    protected function setUp()
    {
        $this->basket = new Basket();
        $this->items = new ShoppingItemSet();
        $this->subject = new Subject($this->items, $this->basket);
    }

    public function calculateDiscount()
    {
        return [
            [0, 1.43, 0.0],
            [1, 1.43, 0.0],
            [2, 1.43, 1.43],
            [3, 1.43, 1.43],
            [4, 1.43, 2 * 1.43],
            [5, 1.43, 2 * 1.43],
            [6, 1.43, 3 * 1.43],
        ];
    }

    /**
     * @dataProvider calculateDiscount
     */
    public function test_calculateDiscount($numItems, $unitPrice, $expected)
    {
        $actual = $this->subject->calculateDiscount($numItems, $unitPrice);

        $this->assertSame($expected, $actual);
    }
    
    public function test_applyDiscount_noDiscounts()
    {
        $total = 123.4;

        $actual = $this->subject->applyDiscount($total);

        $this->assertSame($total, $actual);
    }
    
    public function test_applyDiscount_discountForItemNotInBasket()
    {
        $item1 = new ShoppingItem('PLU 1', '', 1.99);
        $this->basket->add($item1);
        
        $total = 123.4;
        $this->items->add(new ShoppingItem('PLU 2', '', 2.99));

        $actual = $this->subject->applyDiscount($total);

        $this->assertSame($total, $actual);
    }
    
    public function test_applyDiscount_onlyOneItemSoNoDiscount()
    {
        $item1 = new ShoppingItem('PLU 1', '', 1.99);
        $this->basket->add($item1);
        
        $total = 123.4;
        $this->items->add($item1);

        $actual = $this->subject->applyDiscount($total);

        $this->assertSame($total, $actual);
    }
    
    public function test_applyDiscount_twoItemsSoOneDiscount()
    {
        $item1 = new ShoppingItem('PLU 1', '', 1.99);
        $this->basket->add($item1);
        $this->basket->add($item1);
        
        $total = 123.4;
        $this->items->add($item1);

        $actual = $this->subject->applyDiscount($total);

        $this->assertSame($total - 1.99, $actual);
    }
    
    public function test_applyDiscount_differentItemsWachWithDiscount()
    {
        $item1 = new ShoppingItem('PLU 1', '', 1.99);
        $this->basket->add($item1);
        $this->basket->add($item1);
        
        $item2 = new ShoppingItem('PLU 2', '', 2.76);
        $this->basket->add($item2);
        $this->basket->add($item2);
        
        $total = 123.4;
        $this->items->add($item1);
        $this->items->add($item2);

        $actual = $this->subject->applyDiscount($total);

        $this->assertSame($total - 1.99 - 2.76, $actual);
    }
}
