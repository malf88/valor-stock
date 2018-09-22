<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 21/09/2018
 * Time: 23:45
 */

namespace StockValor;


class StockValor
{
    const URL_VALOR_DATA = "https://www.valor.com.br/json.php?module=valor_data";
    /**
     * @var string
     */
    private $action = 'get_series';
    /**
     * Ticker da ação desejada
     * @var string
     */
    private $symbolCode = 'IBOV';
    /**
     * @var int
     */
    private $originId = 1;
    /**
     * Data de início do período
     * @var \DateTime
     */
    private $dateFrom = null;
    /**
     * Data término do período
     * @var \DateTime
     */
    private $dateTo = null;
    /**
     * @var string
     */
    private $typeChart = 'bolsa';

    /**
     * StockValor constructor.
     * @param string $symbolCode
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     */
    public function __construct($symbolCode, \DateTime $dateFrom, \DateTime $dateTo)
    {
        $this->symbolCode = $symbolCode;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    /**
     * @return string
     */
    public function getSymbolCode()
    {
        return $this->symbolCode;
    }

    /**
     * @param string $symbolCode
     */
    public function setSymbolCode($symbolCode)
    {
        $this->symbolCode = $symbolCode;
    }

    /**
     * @return \DateTime
     */
    public function getDateFrom()
    {
        return $this->dateFrom;
    }

    /**
     * @param \DateTime $dateFrom
     */
    public function setDateFrom($dateFrom)
    {
        $this->dateFrom = $dateFrom;
    }

    /**
     * @return \DateTime
     */
    public function getDateTo()
    {
        return $this->dateTo;
    }

    /**
     * @param \DateTime $dateTo
     */
    public function setDateTo($dateTo)
    {
        $this->dateTo = $dateTo;
    }



}