<?php

namespace CodeClanShopping\Test;

use CodeClanShopping\ShoppingItemList as Subject;
use CodeClanShopping\ShoppingItem;

class ShoppingItemListTest extends \PHPUnit_Framework_TestCase
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
    
    public function test_add_allowsDuplicates()
    {
        $item = new ShoppingItem('', '', 1.99);

        // add the same item twice
        $this->subject->add($item);
        $this->subject->add($item);

        $this->assertCount(2, $this->subject->getItems());
    }
    
    public function test_remove_nonExistentItem()
    {
        $item = new ShoppingItem('', '', 1.99);

        $this->subject->remove($item);
    }
    
    public function test_remove_removesItem()
    {
        $item = new ShoppingItem('', '', 1.99);
        $this->subject->add($item);

        $this->subject->remove($item);
        
        $this->assertCount(0, $this->subject->getItems());
    }
    
    public function test_emptyCollection_emptiesCollection()
    {
        $item = new ShoppingItem('', '', 1.99);
        $this->subject->add($item);

        $this->subject->emptyCollection();
        
        $this->assertCount(0, $this->subject->getItems());
    }
}
