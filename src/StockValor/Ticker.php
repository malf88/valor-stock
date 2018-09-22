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
    private $ticker;
    private $ultimoValor;

    /**
     * Ticker constructor.
     * @param $ticker
     * @param $ultimoValor
     */
    public function __construct($ticker, $ultimoValor)
    {
        $this->ticker = $ticker;
        $this->ultimoValor = $ultimoValor;
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
    public function getUltimoValor()
    {
        return $this->ultimoValor;
    }

}