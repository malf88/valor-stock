<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 22/09/2018
 * Time: 00:00
 */

namespace StockValor;
use Curl\Curl;

class ManipulaStockExchange
{
    /**
     * @var Curl
     */
    private $cURL = null;
    public function __construct()
    {
        $this->cURL = new Curl();
    }

    public function getJson(StockValor $stockValor){
        $this->cURL->setHeader('Content-type','text/json');
        $this->cURL->get($stockValor->getURL(),array(
                                                        'module' => 'valor_data',
                                                        'action' => $stockValor->getAction(),
                                                        'symbol_code' => $stockValor->getSymbolCode(),
                                                        'origin_id' => $stockValor->getOriginId(),
                                                        'date_from' => $stockValor->getDateFrom()->format('d/m/Y H:i:s'),
                                                        'date_to' => $stockValor->getDateTo()->format('d/m/Y H:i:s'),
                                                        'type_chart' => $stockValor->getTypeChart(),
                                                        'period' => $stockValor->getPeriod()
                                                    )
        );

        $json = json_decode($this->cURL->response);
        return $json;

    }

    public function getList(StockValor $stockValor){
        $json = $this->getJson($stockValor);
        $list = array();
        foreach ($json->result as $varicao){
            $data = new \DateTime();

            $list[] = $this->createTicker($stockValor->getSymbolCode(),$varicao);
        }
        return $list;
    }
    /**
     * @param StockValor $stockValor
     * @return Ticker
     */
    public  function getLastValue(StockValor $stockValor){
        $json = $this->getJson($stockValor);
        return $this->populateObject($stockValor->getSymbolCode(),$json);
    }

    /**
     * @param $ticker
     * @param $jsonObject
     * @return Ticker
     */
    private function populateObject($ticker,$jsonObject){
        $lastValue = end($jsonObject->result);
        $data = new \DateTime();
        $data->setTimestamp($this->getTimeStamp($lastValue->TimePoint));

        $stock = new Ticker($ticker,$lastValue->Close,$data);
        return $stock;
    }
    public function createTicker($ticker, $variacao){
        $data = new \DateTime();
        $data->setTimestamp($this->getTimeStamp($variacao->TimePoint));
        $stock = new Ticker($ticker,$variacao->Close,$data);
        return $stock;

    }
    public function getTimeStamp($string){
       return substr($string,0,10);
    }
}