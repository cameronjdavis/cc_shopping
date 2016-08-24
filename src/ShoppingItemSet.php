<?php

namespace CodeClanShopping;

/**
 * A collection of shopping items that does not allow duplicates.
 */
class ShoppingItemSet implements ShoppingItemCollection
{
    /**
     * @var ShoppingItem[]
     */
    private $items;

    public function __construct()
    {
        $this->items = [];
    }

    /**
     * Add an item to the set.
     * @param \CodeClanShopping\ShoppingItem $item
     */
    public function add(ShoppingItem $item)
    {
        // if the item is already in the set, do not re-add
        if (array_key_exists($item->getPlu(), $this->items)) {
            return;
        }

        $this->items[$item->getPlu()] = $item;
    }

    /**
     * Get the underlying array of items.
     * @return ShoppingItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Empty this set of items.
     */
    public function emptyCollection()
    {
        $this->items = [];
    }

    /**
     * Remove the item from this set.
     * @param \CodeClanShopping\ShoppingItem $item
     */
    public function remove(ShoppingItem $item)
    {
        // unset the item if it exists
        unset($this->items[$item->getPlu()]);
    }

}
