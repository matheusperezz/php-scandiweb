<?php

namespace models;
require_once 'api/models/Product.php';

class Dvd extends Product
{
    private float $size;

    public function __construct($SKU, $name, $price, float $size)
    {
        parent::__construct($SKU, $name, $price);
        $this->size = $size;
    }

    public function getSize(): float
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }
}