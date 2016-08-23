<?php

namespace CodeClanShopping;

class ShoppingItem
{
    /**
     * Unique retailer ID of the item.
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

    public function __construct($plu, $name, $price)
    {
        $this->plu = $plu;
        $this->name = $name;
        $this->price = $price;
    }

    public function getPlu()
    {
        return $this->plu;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPrice()
    {
        return $this->price;
    }
}
