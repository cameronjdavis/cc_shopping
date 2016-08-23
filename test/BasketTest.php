<?php

namespace CodeClanShopping\Test;

use CodeClanShopping\Basket as Subject;
use CodeClanShopping\ShoppingItem;

class BasketTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Subject
     */
    private $subject;

    protected function setUp()
    {
        $this->subject = new Subject();
    }

    public function test_addItem_itemIsAdded()
    {
        // arrange
        $item = new ShoppingItem('PLU 1', 'Name 1', 7.99);

        // act
        $this->subject->addItem($item);

        // assert
        $items = $this->subject->getContents();
        $firstItem = reset($items);

        $this->assertSame($item, $firstItem);
    }

    public function test_removeItem_itemIsRemoved()
    {
        $item = new ShoppingItem('PLU 1', 'Name 1', 7.99);
        $this->subject->addItem($item);

        $result = $this->subject->removeItem($item);

        $this->assertCount(0, $this->subject->getContents());
        $this->assertTrue($result);
    }

    public function test_removeItem_itemNotInBasket()
    {
        // arrange
        $item1 = new ShoppingItem('PLU 1', 'Name 1', 1.99);
        $this->subject->addItem($item1);

        $item2 = new ShoppingItem('PLU 2', 'Name 2', 2.99);

        // act
        $result = $this->subject->removeItem($item2);

        // assert
        $items = $this->subject->getContents();
        $firstItem = reset($items);

        $this->assertSame($item1, $firstItem);
        $this->assertFalse($result);
    }

    public function test_emptyBasket_emptiesBasket()
    {
        $item = new ShoppingItem('PLU 1', 'Name 1', 1.99);
        $this->subject->addItem($item);

        $this->subject->emptyBasket();

        $this->assertCount(0, $this->subject->getContents());
    }
}
