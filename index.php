<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 21/09/2018
 * Time: 23:52
 */
include 'vendor/autoload.php';
use StockValor\StockValor;
use StockValor\ManipulaStockExchange;

$dataInicio = new \DateTime();
$dataInicio->setDate('2018','09','21');
$dataInicio->setTime('10','00','00');

$dataTermino = new \DateTime();
$dataTermino->setDate('2018','09','22');
$dataTermino->setTime('10','00','00');
$stock = new StockValor('BRFS3', $dataInicio, $dataTermino);

$tucker = $stock->getLastValor();

var_dump($tucker);
