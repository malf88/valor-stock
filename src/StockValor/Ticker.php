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
     * @var \DateTime
     */

    private $data;

    /**
     * Ticker constructor.
     * @param $ticker
     * @param $ultimoValor
     */
    public function __construct($ticker, $valor,$data = null)
    {
        $this->ticker = $ticker;
        $this->valor = $valor;
        $this->data = $data;
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

    /**
     * @return \DateTime
     */
    public function getData()
    {
        return $this->data;
    }
    


}