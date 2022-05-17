<?php

namespace StockValor\Impl;

use StockValor\Value;

interface ServiceImpl
{
    public function getDataFromUrl(DataImpl $data):DataResponseAbstract;
    public function getLastValue(DataImpl $data):Value;
}