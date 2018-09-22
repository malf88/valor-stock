<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 22/09/2018
 * Time: 17:31
 */

namespace StockValor;


class Ticker
{
    /**
     * @var String
     */
    private $ticker;
    /**
     * @var double
     */
    private $valor;

    /**
     * Ticker constructor.
     * @param $ticker
     * @param $ultimoValor
     */
    public function __construct($ticker, $valor)
    {
        $this->ticker = $ticker;
        $this->valor = $valor;
    }

    /**
     * @return mixed
     */
    public function getTicker()
    {
        return $this->ticker;
    }

    /**
     * @return mixed
     */
    public function getValor()
    {
        return $this->valor;
    }


}