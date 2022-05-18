<?php

namespace StockValor\Impl;

use StockValor\Value;
use \DateTime;
class DataResponseAbstract
{
    private string $currency;
    private array $prices;
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
        $prices = [];
        foreach ($this->prices as $price){
            $prices[] = new Value(
                $price->price,
                DateTime::createFromFormat(DataStatusInvestAbstract::$DATE_FORMAT_BR,$price->date)
            );
        }
        return $prices;
    }
}