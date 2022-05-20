<?php

namespace StockValor;

use StockValor\Impl\DataAbstract;
use StockValor\Impl\DataResponseAbstract;
use DateTime;
class DataResponseStatusInvest extends DataResponseAbstract
{
    /**
     * @return array
     */
    public function getPrices(): array
    {
        $prices = [];
        foreach ($this->prices as $price){
            $prices[] = new Value(
                $price->price,
                DateTime::createFromFormat(DataAbstract::$DATE_FORMAT_BR,$price->date)
            );
        }
        return $prices;
    }
}