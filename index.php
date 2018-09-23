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

$stock = new StockValor('TIET11');

$tucker = $stock->getListValue();


/**
 * Pegar lista de cotações de um período
 */

$dateInicio = new DateTime();
$dateInicio->setDate('2018','09','21');
$dateInicio->setTime('10','00','00');

$dateTermino = new DateTime();
$dateTermino->setDate('2018','09','21');
$dateTermino->setTime('18','00','00');

$stock = new StockValor('TIET11',$dateInicio,$dateTermino);

$tucker = $stock->getListValue();

var_dump($tucker);
