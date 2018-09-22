<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 21/09/2018
 * Time: 23:52
 */
include 'vendor/autoload.php';
use StockValor\StockValor;

$stock = new StockValor('TIET11');

$tucker = $stock->getLastValor();

var_dump($tucker);
