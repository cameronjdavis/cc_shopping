<?php

namespace CodeClanShopping\Test\Discounts;

use CodeClanShopping\Discounts\DiscountList as Subject;
use CodeClanShopping\Discount;

class DiscountListTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Subject
     */
    private $subject;

    protected function setUp()
    {
        $this->subject = new Subject();
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Only objects of type CodeClanShopping\Discount can be added.
     */
    public function test_append_wrongType()
    {
        $discount = new \stdClass();

        $this->subject->append($discount);
    }

    public function test_applyDiscount_noDiscounts()
    {
        $actual = $this->subject->applyDiscount(123.4);

        $this->assertEquals(123.4, $actual);
    }

    public function test_applyDiscount_discountsApplied()
    {
        // arrange
        $total = 987.6;

        $discount1 = $this->createMock(Discount::class);
        $discount1->expects($this->once())
                ->method('applyDiscount')
                ->with($total)
                ->willReturn(765.4);

        $discount2 = $this->createMock(Discount::class);
        $discount2->expects($this->once())
                ->method('applyDiscount')
                ->with(765.4)
                ->willReturn(543.2);

        $this->subject->append($discount1);
        $this->subject->append($discount2);

        // act
        $actual = $this->subject->applyDiscount($total);

        // assert
        $this->assertEquals(543.2, $actual);
    }
}
