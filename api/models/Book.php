<?php

namespace models;
require_once 'api/models/Product.php';

class Book extends Product
{
    private float $weight;

    public function __construct($SKU, $name, $price, float $weight)
    {
        parent::__construct($SKU, $name, $price);
        $this->weight = $weight;
    }

    public function getWeight(): float
    {
        return $this->weight;
    }

    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }


}