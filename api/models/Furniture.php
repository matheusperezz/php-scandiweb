<?php

namespace models;
require_once 'api/models/Product.php';

class Furniture extends Product
{
    private float $height;
    private float $width;
    private float $length;

    public function __construct($SKU, $name, $price, $height, $width, $length)
    {
        parent::__construct($SKU, $name, $price);
        $this->height = $height;
        $this->width = $width;
        $this->length = $length;
    }

    public function getFormatedAllDimensions(): string
    {
        $dimensions = $this;
        return "{$dimensions->height}x{$dimensions->width}x{$dimensions->length}";
    }

    public function getHeight(): float
    {
        return $this->height;
    }

    public function setHeight(float $height): void
    {
        $this->height = $height;
    }

    public function getWidth(): float
    {
        return $this->width;
    }

    public function setWidth(float $width): void
    {
        $this->width = $width;
    }

    public function getLength(): float
    {
        return $this->length;
    }

    public function setLength(float $length): void
    {
        $this->length = $length;
    }

}