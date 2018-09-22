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
    public  function getLastValue(StockValor $stockValor){
        $json = $this->getJson($stockValor);
        return $this->populaObjeto($stockValor->getSymbolCode(),$json);
    }
    private function populaObjeto($ticker,$jsonObject){
        $lastValue = end($jsonObject->result);
        $stock = new Ticker($ticker,$lastValue->Close);
        return $stock;
    }
}