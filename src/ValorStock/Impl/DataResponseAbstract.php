<?php

namespace StockValor\Impl;

use StockValor\Value;
use \DateTime;
class DataResponseAbstract
{
    protected string $currency;
    protected array $prices;
    public function __construct(string $currency, array $prices)
    {
        $this->currency = $currency;
        $this->prices = $prices;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return array
     */
    public function getPrices(): array
    {
       return [
           new Value(
            $this->prices[0]->price,
            $this->prices[0]->date
           )
       ];
    }


}