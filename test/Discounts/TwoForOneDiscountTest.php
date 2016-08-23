<?php

namespace CodeClanShopping\Test;

use CodeClanShopping\Discounts\TwoForOneDiscount as Subject;
use CodeClanShopping\Discount;
use CodeClanShopping\Basket;

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
}
