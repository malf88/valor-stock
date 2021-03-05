<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 21/09/2018
 * Time: 23:52
 */
include 'vendor/autoload.php';

use StockValor\ManipulaStockExchange;
use StockValor\StockValor;

/**
 * Pegar última cotação
 */

$stock = new StockValor('BRFS3');
$stock->setIdClientEasyvest('teste');
$tucker = $stock->getValue();

var_dump($stock->getLastValueInDate(new DateTime('2021-03-04')));

/**
 * Pegar lista de cotações de um período
**/
//var_dump($stock->getStatus());
$dateInicio = new DateTime();
$dateInicio->setDate('2018','10','04');
$dateInicio->setTime('10','00','00');

$dateTermino = new DateTime();
$dateTermino->setDate('2019','10','04');
$dateTermino->setTime('18','00','00');

$stock = new StockValor('IBOV',$dateInicio,$dateTermino);
 
//$stock->setIdClientEasyvest('IDEASYINVEST');

//$tucker = $stock->getValue();
//$tucker = $stock->getIbov();
//$tucker = $stock->getIbovVariacao();
//$stock->setDateFrom($dateInicio);
//$stock->setDateTo($dataTermino);

var_dump($stock->getLastValueInDate(new DateTime('2021-02-18'),ManipulaStockExchange::TYPE_STOCK_INDEX));
