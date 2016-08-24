<?php

namespace CodeClanShopping;

/**
 * A collection of shopping items that does not allow duplicates.
 */
class ShoppingItemSet
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
     * Get the unerlying array of items.
     * @return ShoppingItem[]
     */
    public function getItems()
    {
        return $this->items;
    }

    // @todo: add remove() and empty() methods, which aren't needed for this project
}
