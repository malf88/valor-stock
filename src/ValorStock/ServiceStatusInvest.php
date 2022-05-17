<?php

namespace StockValor;

use StockValor\Impl\DataImpl;
use StockValor\Impl\ServiceImpl;
use StockValor\Traits\Request;

class ServiceStatusInvest implements ServiceImpl
{
    use Request;
    const URL_SERVICE = 'https://statusinvest.com.br/acao/tickerprice';
    const METHOD_SERVICE = 'POST';

    public function getDataFromUrl(DataImpl $dataStatusInvest): array
    {

        $dataResponse = $this->getRequestService(self::URL_SERVICE)
            ->request(
                self::METHOD_SERVICE,
                self::URL_SERVICE,
                ['form_params' => $dataStatusInvest->toData()]
            );
        return json_decode($dataResponse->getBody()->getContents());
    }
}