<?php

namespace models;

abstract class Product
{
    private string $SKU;
    private string $name;
    private float $price;

    public function __construct(string $SKU, string $name, float $price){
        $this->SKU = $SKU;
        $this->name = $name;
        $this->price = $price;
    }

    public function getSKU(): string
    {
        return $this->SKU;
    }

    public function setSKU($SKU)
    {
        $this->SKU = $SKU;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

}