<?php

namespace CodeClanShopping;

/**
 * Top-level interface for all types of shopping item collection.
 */
interface ShoppingItemCollection
{

    /**
     * Add an item to the collection.
     * @param \CodeClanShopping\ShoppingItem $item
     */
    public function add(ShoppingItem $item);

    /**
     * Remove an item from the collection.
     * @param \CodeClanShopping\ShoppingItem $item
     */
    public function remove(ShoppingItem $item);

    /**
     * Empty the collection.
     */
    public function emptyCollection();

    /**
     * @return ShoppingItem[] Aray of items in the collection.
     */
    public function getItems();
}
