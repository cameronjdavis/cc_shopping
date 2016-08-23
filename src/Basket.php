<?php

namespace CodeClanShopping;

class Basket
{
    private $items;

    public function __construct()
    {
        $this->items = [];
    }

    /**
     * Add an item to the basket.
     * @param \CodeClanShopping\ShoppingItem $item
     */
    public function addItem(ShoppingItem $item)
    {
        $this->items[] = $item;
    }

    /**
     * Remove the item from the basket if it exists.
     * @param \CodeClanShopping\ShoppingItem $toBeRemoved
     * @return boolean True if item was in basket, otherwise false.
     */
    public function removeItem(ShoppingItem $toBeRemoved)
    {
        // key of the item if it is found in the array
        $foundKey = null;
        // true if we found the item
        $result = false;

        foreach ($this->getContents() as $key => $item) {
            // if we find a matching item
            if ($item->getPlu() == $toBeRemoved->getPlu()) {
                $foundKey = $key;
                $result = true;

                // we have found the item so stop looking
                break;
            }
        }

        // if the item was found then remove it
        if ($result) {
            unset($this->items[$foundKey]);
        }

        return $result;
    }

    /**
     * Empty the basket of all items.
     */
    public function emptyBasket()
    {
        $this->items = [];
    }

    /**
     * Get the collection of shopping items.
     * @return ShoppingItem[]
     */
    public function getContents()
    {
        return $this->items;
    }
}
