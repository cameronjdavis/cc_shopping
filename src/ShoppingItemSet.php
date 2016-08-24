<?php

namespace CodeClanShopping;

/**
 * A collection of shopping items that does not allow duplicates.
 */
class ShoppingItemSet extends ShoppingItemList
{

    /**
     * Add an item to the set.
     * @param \CodeClanShopping\ShoppingItem $item
     */
    public function add(ShoppingItem $item)
    {
        // if the item is already in the set, do not re-add
        if (array_search($item, $this->getItems()) !== false) {
            return;
        }

        return parent::add($item);
    }
}
