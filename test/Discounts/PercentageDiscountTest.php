<?php

namespace CodeClanShopping\Test\Discounts;

use CodeClanShopping\Discounts\PercentageDiscount as Subject;

class PercentageDiscountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Subject
     */
    private $subject;

    public function applyDiscount()
    {
        return [
            [100.0, 0.0, 100.0],
            [100.0, 1.0, 0.0],
            [100.0, 0.15, 85.0],
            [0.0, 0.15, 0.0], // cannot go below 0 for total
            [0.0, 1.15, 0.0], // discount is 115%
        ];
    }

    /**
     * @dataProvider applyDiscount
     */
    public function test_applyDiscount($total, $percentage, $expected)
    {
        $this->subject = new Subject($percentage);

        $actual = $this->subject->applyDiscount($total);

        $this->assertSame($expected, $actual);
    }
}
