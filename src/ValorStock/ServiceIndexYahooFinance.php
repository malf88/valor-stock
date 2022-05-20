<?php

namespace StockValor;

use Scheb\YahooFinanceApi\ApiClientFactory;
use StockValor\Exceptions\ServiceException;
use StockValor\Impl\DataImpl;
use StockValor\Impl\DataResponseAbstract;
use StockValor\Impl\ServiceImpl;
use StockValor\Traits\Request;
use \DateTime;
class ServiceIndexYahooFinance
    extends ServiceYahooFinance
    implements ServiceImpl
{
    use Request;

    public function getDataFromUrl(DataImpl $dataYahooFinance): DataResponseAbstract
    {

        $client = ApiClientFactory::createApiClient($this->getRequestService());
        $quoteStock = $client->getQuote('^'.$dataYahooFinance->toData());
        if($quoteStock == null) throw new ServiceException('Ticker not found');

        return new DataResponseYahooFinance($quoteStock->getCurrency(),
            [
                (object)[
                    'date' => $quoteStock->getRegularMarketTime(),
                    'price' => $quoteStock->getRegularMarketPrice()
                ]
            ]);
    }


}