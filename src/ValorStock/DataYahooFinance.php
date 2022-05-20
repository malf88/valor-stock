<?php

namespace StockValor;

use StockValor\Impl\DataAbstract;

class DataYahooFinance extends DataAbstract
{
    public function toData()
    {
        return $this->getTicker();
    }
}