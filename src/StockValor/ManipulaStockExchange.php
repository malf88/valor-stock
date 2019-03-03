<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 22/09/2018
 * Time: 00:00
 */

namespace StockValor;
use Curl\Curl;
use Dotenv\Dotenv;

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

        if(isset($json->result)){
            $json = json_decode($this->cURL->response);
            return $json;
        }else{
            $json = json_decode($this->getJsonInfomoney($stockValor));
            return $json;
        }

    }

    public function getInfoRealTime(StockValor $stockValor){
        if($stockValor->getIdClientEasyvest() == null){
            throw new \Exception('Informe o id de cliente da easyinvest para utilizar a cotação em tempo real');
        }
        $url = $stockValor->getUrlRealTime();
        if(getenv('URL_STOCK_VALOR_REAL_TIME')){
            $url = getenv('URL_STOCK_VALOR_REAL_TIME');
        }
        $this->cURL->get($url,array(
                'q' => $stockValor->getSymbolCode(),
                'c' => $stockValor->getIdClientEasyvest(),
                't' => 'webgateway'
            )
        );

        $cotacao = $this->cURL->response->Value[0]->Ps;
        $data = $this->manipulaDataEasyinvest($cotacao->LTDT);
        $ticker = new Ticker($cotacao->S,$cotacao->P,$data);

        return $ticker;



    }

    public function manipulaDataEasyinvest($data){

        $ano = substr($data,0,4);
        $mes = substr($data,4,2);
        $dia = substr($data,6,2);
        $hora = substr($data,8,2);
        $minuto = substr($data,10,2);
        $segundo = substr($data,12,2);

        $data = new \DateTime();
        $data->setDate($ano,$mes,$dia);
        $data->setTime($hora,$minuto,$segundo);
        return $data;

    }

    public function getJsonInfomoney(StockValor $stockValor){
        $this->cURL->get($stockValor->getURLInfomoney(),array(
                'chart' => 'Intraday',
                'stockcode' => $stockValor->getSymbolCode()
            )
        );
        if($this->cURL->getHttpStatusCode() != '200') throw new \Exception('Ticker não encontrado');
        $dados = explode("\r\n",$this->cURL->response);

        $variacao['result'] = array();
        foreach ($dados as $key => $dado){

            $info = explode(';',$dado);

            if(count($info) <= 1) continue;
            $json['result'][$key]['Close'] = $info[1];
            $data = \DateTime::createFromFormat('Y-m-d H:i',$info[0],new \DateTimeZone('America/Sao_Paulo'));

            $json['result'][$key]['TimePoint'] = $data->getTimestamp();
        }

        return json_encode($json);

    }
    public function getCurl(){
        return $this->cURL;
    }
    public function getList(StockValor $stockValor){

        $json = $this->getJson($stockValor);
        $list = array();
        try {

            if(count($json->result) > 0) {
                foreach ($json->result as $varicao) {

                    $list[] = $this->createTicker($stockValor->getSymbolCode(), $varicao);
                }
                return $list;
            }else{
                throw new \Exception('Ticker não encontrado');
            }
        }catch (\Exception $e){
            throw $e;
        }
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

        if(is_array($jsonObject->result) && count($jsonObject->result) > 0) {
            $lastValue = end($jsonObject->result);
            $data = new \DateTime();
            $data->setTimestamp($this->getTimeStamp($lastValue->TimePoint));

            $stock = new Ticker($ticker, $lastValue->Close, $data);
            return $stock;
        }else{
            throw new \Exception('Erro ao popular objeto');
        }
    }

    /**
     * @param $ticker
     * @param $variacao
     * @return Ticker
     * @throws \Exception
     */
    public function createTicker($ticker, $variacao){
        $data = new \DateTime();
        if(!empty($variacao->TimePoint) && !empty($variacao->Close)) {
            $data->setTimestamp($this->getTimeStamp($variacao->TimePoint));
            $stock = new Ticker($ticker, $variacao->Close, $data);
            return $stock;
        }else{
            throw new \Exception('Erro ao buscar informações do ticker');
        }

    }
    public function getTimeStamp($string){
       return substr($string,0,10);
    }
}