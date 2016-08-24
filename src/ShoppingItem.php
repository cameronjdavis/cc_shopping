<?php

namespace CodeClanShopping;

/**
 * A single item that a customer puts in their basket.
 * E.g. a banana, or a carton of eggs.
 * Shopping items are identified by their PLU (price look-up code).
 */
class ShoppingItem
{
    /**
     * Unique retailer ID of the item.
     * PLU = price look-up code.
     * @var string
     */
    private $plu;

    /**
     * Display name of the item.
     * @var string
     */
    private $name;

    /**
     * Unit price of the item.
     * @var float
     */
    private $price;

    /**
     * @param string $plu
     * @param string $name
     * @param float $price
     */
    public function __construct($plu, $name, $price)
    {
        $this->plu = $plu;
        $this->name = $name;
        $this->price = $price;
    }

    /**
     * Get the item's PLU.
     * @return string
     */
    public function getPlu()
    {
        return $this->plu;
    }

    /**
     * Get the item's display name.
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the item's unit price.
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
    
    // @todo: Add setters depending on requirements outside the scope of this project.
}
