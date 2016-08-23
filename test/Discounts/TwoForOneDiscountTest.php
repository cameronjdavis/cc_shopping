<?php

namespace CodeClanShopping\Test;

use CodeClanShopping\Discounts\TwoForOneDiscount as Subject;
use CodeClanShopping\Basket;
use CodeClanShopping\ShoppingItem;

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

    protected function setUp()
    {
        $this->basket = new Basket();
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
        $this->subject = new Subject([], $this->basket);

        $actual = $this->subject->calculateDiscount($numItems, $unitPrice);

        $this->assertSame($expected, $actual);
    }
    
    public function test_applyDiscount_noDiscounts()
    {
        $total = 123.4;
        $this->subject = new Subject([], $this->basket);

        $actual = $this->subject->applyDiscount($total);

        $this->assertSame($total, $actual);
    }
    
    public function test_applyDiscount_discountForItemNotInBasket()
    {
        $item1 = new ShoppingItem('PLU 1', '', 1.99);
        $this->basket->addItem($item1);
        
        $total = 123.4;
        $this->subject = new Subject(['PLU 2'], $this->basket);

        $actual = $this->subject->applyDiscount($total);

        $this->assertSame($total, $actual);
    }
    
    public function test_applyDiscount_onlyOneItemSoNoDiscount()
    {
        $item1 = new ShoppingItem('PLU 1', '', 1.99);
        $this->basket->addItem($item1);
        
        $total = 123.4;
        $this->subject = new Subject(['PLU 1'], $this->basket);

        $actual = $this->subject->applyDiscount($total);

        $this->assertSame($total, $actual);
    }
    
    public function test_applyDiscount_twoItemsSoOneDiscount()
    {
        $item1 = new ShoppingItem('PLU 1', '', 1.99);
        $this->basket->addItem($item1);
        $this->basket->addItem($item1);
        
        $total = 123.4;
        $this->subject = new Subject(['PLU 1'], $this->basket);

        $actual = $this->subject->applyDiscount($total);

        $this->assertSame($total - 1.99, $actual);
    }
    
    public function test_applyDiscount_differentItemsWachWithDiscount()
    {
        $item1 = new ShoppingItem('PLU 1', '', 1.99);
        $this->basket->addItem($item1);
        $this->basket->addItem($item1);
        
        $item2 = new ShoppingItem('PLU 2', '', 2.76);
        $this->basket->addItem($item2);
        $this->basket->addItem($item2);
        
        $total = 123.4;
        $this->subject = new Subject(['PLU 1', 'PLU 2'], $this->basket);

        $actual = $this->subject->applyDiscount($total);

        $this->assertSame($total - 1.99 - 2.76, $actual);
    }
}
