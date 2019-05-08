<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 21/09/2018
 * Time: 23:52
 */
include 'vendor/autoload.php';
use StockValor\StockValor;

/**
 * Pegar última cotação
 */

$stock = new StockValor('IBOV');

//$tucker = $stock->getListValue();


/**
 * Pegar lista de cotações de um período

var_dump($stock->getStatus());
$dateInicio = new DateTime();
$dateInicio->setDate('2018','10','04');
$dateInicio->setTime('10','00','00');

$dateTermino = new DateTime();
$dateTermino->setDate('2018','10','04');
$dateTermino->setTime('18','00','00');

$stock = new StockValor('VVAR11',$dateInicio,$dateTermino);
 */
$stock->setIdClientEasyvest('6536185');

//$tucker = $stock->getValue();

$tucker = $stock->getIbovVariacao();


var_dump($tucker);
