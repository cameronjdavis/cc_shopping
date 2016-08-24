<?php

namespace CodeClanShopping\Test\Discounts;

use CodeClanShopping\Discounts\TotalThresholdDiscount as Subject;
use CodeClanShopping\Discount;

class TotalThresholdDiscountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Subject
     */
    private $subject;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $discount;

    protected function setUp()
    {
        $this->discount = $this->createMock(Discount::class);
    }

    public function test_applyDiscount_totalAboveThreshold()
    {
        $total = 987.6;
        $this->subject = new Subject(10.0, $this->discount);

        $this->discount->expects($this->once())
                ->method('applyDiscount')
                ->with($total)
                ->willReturn(123.4);

        $actual = $this->subject->applyDiscount($total);

        $this->assertEquals(123.4, $actual);
    }

    public function test_applyDiscount_totalEqualsThreshold()
    {
        $total = 987.6;
        $this->subject = new Subject($total, $this->discount);

        $this->discount->expects($this->once())
                ->method('applyDiscount')
                ->with($total)
                ->willReturn(123.4);

        $actual = $this->subject->applyDiscount($total);

        $this->assertEquals(123.4, $actual);
    }

    public function test_applyDiscount_totalBelowThreshold()
    {
        $total = 987.6;
        $this->subject = new Subject(1000.0, $this->discount);

        $this->discount->expects($this->never())
                ->method('applyDiscount');

        $actual = $this->subject->applyDiscount($total);

        $this->assertEquals($total, $actual);
    }
}
