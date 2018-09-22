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
    const URL_VALOR_DATA = "https://www.valor.com.br/json.php";//?module=valor_data
    /**
     * @var string
     */
    private $action = 'get_serie';
    /**
     * Ticker da ação desejada
     * @var string
     */
    private $symbolCode = 'IBOV';
    /**
     * @var int
     */
    private $originId = 2;
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
    private $typeChart = 'bolsas';
    /**
     * @var int
     */

    private $period = '1';

    /**
     * StockValor constructor.
     * @param string $symbolCode
     * @param \DateTime $dateFrom
     * @param \DateTime $dateTo
     */
    public function __construct($symbolCode, \DateTime $dateFrom = null, \DateTime $dateTo = null)
    {
        $this->symbolCode = $symbolCode;

        $this->dateFrom =($dateFrom != null)? $dateFrom : new \DateTime();
        $this->dateTo =($dateTo != null)? $dateTo : new \DateTime();;
    }

    public function getURL()
    {
        return self::URL_VALOR_DATA;
    }

    public function getJson(){
        $manipulador = new ManipulaStockExchange();
        return $manipulador->getJson($this);
    }

    public function getLastValor(){
        $manipulador = new ManipulaStockExchange();
        return $manipulador->getLastValue($this);
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

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return int
     */
    public function getOriginId()
    {
        return $this->originId;
    }

    /**
     * @return string
     */
    public function getTypeChart()
    {
        return $this->typeChart;
    }

    /**
     * @return int
     */
    public function getPeriod()
    {
        return $this->period;
    }



}