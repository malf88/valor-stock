<?php

namespace StockValor;
use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;
use GuzzleHttp\Exception\ConnectException;
use StockValor\Exceptions\ServiceException;
use StockValor\Helpers\DateHelper;
use StockValor\Impl\DataImpl;
use StockValor\Impl\DataResponseAbstract;
use StockValor\Impl\ServiceImpl;
use StockValor\Traits\Request;
use \DateTime;
class ServiceYahooFinance implements ServiceImpl
{
    use Request;
    public function getDataFromUrl(DataImpl $dataYahooFinance): DataResponseAbstract
    {

        $client = ApiClientFactory::createApiClient($this->getRequestService());
        $quoteStock = $client->getQuote($dataYahooFinance->toData().'.SA');
        if($quoteStock == null) throw new ServiceException('Ticker not found');


        return new DataResponseYahooFinance($quoteStock->getFinancialCurrency(),
            [
                (object)[
                    'date' => $quoteStock->getRegularMarketTime(),
                    'price' => $quoteStock->getRegularMarketPrice()
                ]
            ]);
    }

    public function getLastValue(DataImpl $dataYahooFinance):Value
    {
        try{
            $responseData = $this->getDataFromUrl($dataYahooFinance);
            $prices = $responseData->getPrices();
            return end($prices);
        }catch (ServiceException $e){
            throw $e;
        }

    }
}