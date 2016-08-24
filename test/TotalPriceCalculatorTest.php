<?php

namespace CodeClanShopping\Test;

use CodeClanShopping\TotalPriceCalculator as Subject;
use CodeClanShopping\Basket;
use CodeClanShopping\ShoppingItem;

class TotalPriceCalculatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Subject
     */
    private $subject;

    /**
     * @var Basket;
     */
    private $basket;

    protected function setUp()
    {
        $this->basket = new Basket();
        $this->subject = new Subject();
    }

    public function test_calculateTotal_noItems()
    {
        $actual = $this->subject->calculateTotal($this->basket);

        $this->assertSame(0.0, $actual);
    }

    public function test_calculateTotal_oneItem()
    {
        $item1 = new ShoppingItem('', '', 1.99);
        $this->basket->add($item1);

        $actual = $this->subject->calculateTotal($this->basket);

        $this->assertSame(1.99, $actual);
    }

    public function test_calculateTotal_twoItems()
    {
        // arrange
        $item1 = new ShoppingItem('', '', 1.99);
        $this->basket->add($item1);
        $this->basket->add($item1);

        // act
        $actual = $this->subject->calculateTotal($this->basket);

        // assert
        $this->assertSame(1.99 + 1.99, $actual);
    }
}
