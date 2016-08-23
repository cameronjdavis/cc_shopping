<?php

namespace CodeClanShopping\Test;

use CodeClanShopping\Rounding as Subject;

class RoundingTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Subject
     */
    private $subject;

    protected function setUp()
    {
        $this->subject = new Subject();
    }

    public function roundPrice()
    {
        return [
            [0, 0.00],
            [0.02, 0.02],
            [0.023, 0.02],
            [0.025, 0.02],
            [0.026, 0.02],
            [1.026, 1.02],
        ];
    }

    /**
     * @dataProvider roundPrice
     */
    public function test_roundPrice($price, $expected)
    {
        $actual = $this->subject->roundPrice($price);

        $this->assertSame($expected, $actual);
    }
}
