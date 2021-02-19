<?php
/**
 * Created by PhpStorm.
 * User: marcoaurelio
 * Date: 22/09/2018
 * Time: 00:00
 */

namespace StockValor;
use Curl\Curl;
use DateTime;
use Dotenv\Dotenv;
use Exception;
use GuzzleHttp\Client;

class ManipulaStockExchange
{
    /**
     * @var Curl
     */

    const URL_DATA = 'https://marketdata-streamer.smarttbot.com/data/candles/day/';
    private $cURL = null;
    public function __construct()
    {
        
        $this->cURL = new Client();
    }
    /**
     * Undocumented function
     * @deprecated 
     * @param StockValor $stockValor
     * @return void
     */
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
        

    }

    

    public function _getenv($env){
        if(function_exists('env')){
            env($env);
        }else{
            getenv($env);
        }
    }

    public function curlRealTime(StockValor $stockValor){
        if($stockValor->getIdClientEasyvest() == null){
            throw new \Exception('Informe o id de cliente da easyinvest para utilizar a cotação em tempo real');
        }
        $url = $stockValor->getUrlRealTime();
        if($this->_getenv('URL_STOCK_VALOR_REAL_TIME')){
            $url = $this->_getenv('URL_STOCK_VALOR_REAL_TIME');
        }

        $client = new \GuzzleHttp\Client();
        $response = $client->get($url.'?q='.$stockValor->getSymbolCode().'&c='.$stockValor->getIdClientEasyvest().'&t=webgateway');

        //print_r($response->getBody()->getContents());
        return json_decode($response->getBody()->getContents());
    }
    public function getInfoRealTime(StockValor $stockValor){

        $curl = $this->curlRealTime($stockValor);
        $cotacao = $curl->Value[0]->Ps;

        $data = $this->manipulaDataEasyinvest($cotacao->LTDT);
        $ticker = new Ticker($cotacao->S,$cotacao->P,$data);

        return $ticker;



    }

    public function getIBOV(StockValor $stockValor){
        $stockValor->setSymbolCode('IBOV');
        $curl = $this->curlRealTime($stockValor);
        $cotacao = $curl->Value[0]->Ps;
        return $cotacao->P;

    }

    public function getIBOVVariacao(StockValor $stockValor){
        $stockValor->setSymbolCode('IBOV');
        $curl = $this->curlRealTime($stockValor);

        $cotacao = $curl->Value[0]->Ps;
        return  ((($cotacao->P * 100) / $cotacao->OP) - 100);

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

    public function getJsonObject(StockValor $stockValor){
        $request = $this->cURL->get(self::URL_DATA.$stockValor->getSymbolCode().'/',['query'=>array(
                                                        'token' => 'v8D28VphLj8ngWgiyPwo5bCJLYwTbmkI3DqpimlwhHc=',
                                                        'start_datetime' => $stockValor->getDateFrom()->format('Y-m-d\TH:i:s'),
                                                        'end_datetime' => $stockValor->getDateTo()->format('Y-m-d\TH:i:s'),
                                                        'username' => '_',
                                                        'data_type' => 'delay',
                                                        'origin'    =>  'bussola',
                                                        'expiration_date' => '1613778597951'
                                                    )]
        );
        
        return json_decode( $request->getBody()->getContents());
        

    }

    public function getListStockObject(StockValor $stockValor){
        $arrayList = $this->getJsonObject($stockValor);
        
        $listResult = [];

        foreach($arrayList as $item){
            $listResult[] = new Ticker($stockValor->getSymbolCode(),$item->close,new DateTime($item->datetime));
        }
        return $listResult;
    }

    public function getLastValueInDate(StockValor $stockValor,DateTime $date){
        $dataInicio = new DateTime($date->format('Y-m-d 00:00:00'));

        $dataTermino = new DateTime($date->format('Y-m-d 23:59:59'));

        $stockValor->setDateFrom($dataInicio);
        $stockValor->setDateTo($dataTermino);
        
        $listObject = $this->getListStockObject($stockValor);
        

        if(count($listObject) > 1){
            throw new Exception('A data escolhida retorna mais de um registro');
        }
        return $listObject;

    }
}