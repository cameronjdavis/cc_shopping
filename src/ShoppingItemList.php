<?php

namespace CodeClanShopping;

/**
 * A collection of shopping items that allows duplicates.
 */
class ShoppingItemList implements ShoppingItemCollection
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
        $this->items[] = $item;
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
        if (($key = array_search($item, $this->items)) !== false) {
            unset($this->items[$key]);
        }
    }
}
