<?php

namespace CodeClanShopping\Test\Discounts;

use CodeClanShopping\Discounts\LoyaltyDiscount as Subject;
use CodeClanShopping\Discount;

class LoyaltyDiscountTest extends \PHPUnit_Framework_TestCase
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

    public function test_applyDiscount_isLoyal()
    {
        $this->subject = new Subject(true, $this->discount);
        $total = 987.6;

        $this->discount->expects($this->once())
                ->method('applyDiscount')
                ->with($total)
                ->willReturn(123.4);

        $actual = $this->subject->applyDiscount($total);

        $this->assertEquals(123.4, $actual);
    }

    public function test_applyDiscount_isNotLoyal()
    {
        $this->subject = new Subject(false, $this->discount);
        $total = 987.6;

        $this->discount->expects($this->never())
                ->method('applyDiscount');

        $actual = $this->subject->applyDiscount($total);

        $this->assertEquals($total, $actual);
    }
}
