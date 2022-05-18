<?php

namespace StockValor;
use \DateTime;
class Value
{
    private float $price;
    private DateTime $date;
    public function __construct(float $price, DateTime $date)
    {
        $this->price = $price;
        $this->date = $date;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     */
    public function setDate(DateTime $date): void
    {
        $this->date = $date;
    }

}