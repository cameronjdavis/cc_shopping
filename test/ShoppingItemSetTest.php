<?php

namespace CodeClanShopping\Test;

use CodeClanShopping\ShoppingItemSet as Subject;
use CodeClanShopping\ShoppingItem;

class ShoppingItemSetTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Subject
     */
    private $subject;

    protected function setUp()
    {
        $this->subject = new Subject();
    }

    public function test_add_addsItem()
    {
        $item = new ShoppingItem('', '', 1.99);

        $this->subject->add($item);

        $this->assertCount(1, $this->subject->getItems());
    }
    
    public function test_add_noDuplicates()
    {
        $item = new ShoppingItem('', '', 1.99);

        // add the same item twice
        $this->subject->add($item);
        $this->subject->add($item);

        $this->assertCount(1, $this->subject->getItems());
    }
}
