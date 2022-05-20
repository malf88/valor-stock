<?php

namespace StockValor;

use StockValor\Exceptions\ServiceException;
use StockValor\Impl\DataImpl;
use StockValor\Impl\DataResponseAbstract;
use StockValor\Impl\ServiceImpl;
use StockValor\Traits\Request;
use \DateTime;
class ServiceStatusInvest implements ServiceImpl
{
    use Request;
    const URL_SERVICE = 'https://statusinvest.com.br/acao/tickerprice';
    const METHOD_SERVICE = 'POST';

    public function getDataFromUrl(DataImpl $dataStatusInvest): DataResponseAbstract
    {

        $dataResponse = $this->getRequestService(self::URL_SERVICE)
            ->request(
                self::METHOD_SERVICE,
                self::URL_SERVICE,
                ['form_params' => $dataStatusInvest->toData()]
            );
        $data = json_decode($dataResponse->getBody()->getContents());
        if(count($data[0]->prices) == 0) throw new ServiceException('Ticker not found');

        return new DataResponseStatusInvest($data[0]->currency, $data[0]->prices);
    }

    public function getLastValue(DataImpl $dataStatusInvest):Value
    {
        try{
            $responseData = $this->getDataFromUrl($dataStatusInvest);
            $prices = $responseData->getPrices();
            return end($prices);
        }catch (ServiceException $e){
            throw $e;
        }

    }
}