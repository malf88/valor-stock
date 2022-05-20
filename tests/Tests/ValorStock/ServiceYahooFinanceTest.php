<?php

namespace Tests\Tests\ValorStock;

use PHPUnit\Framework\TestCase;
use StockValor\DataYahooFinance;
use StockValor\Exceptions\ServiceException;
use StockValor\Impl\DataResponseAbstract;
use StockValor\ServiceStatusInvest;
use StockValor\ServiceYahooFinance;
use StockValor\Value;
use DateTime;
class ServiceYahooFinanceTest extends TestCase
{
    /**
     * @test
     */
    public function findDataFromTicker()
    {
        $serviceStatusInvest = new ServiceYahooFinance();
        $dataRequest = new DataYahooFinance('BRFS3');

        $responseData = $serviceStatusInvest->getDataFromUrl($dataRequest);

        $this->assertInstanceOf(DataResponseAbstract::class,$responseData);

    }

    /**
     * @test
     */
    public function findLastFromTicker()
    {
        $serviceStatusInvest = new ServiceYahooFinance();
        $dataRequest = new DataYahooFinance('BRFS3');

        $responseData = $serviceStatusInvest->getLastValue($dataRequest);
        $this->assertInstanceOf(Value::class,$responseData);
        $this->assertIsFloat($responseData->getPrice());
        $this->assertInstanceOf(DateTime::class,$responseData->getDate());

    }

    /**
     * @test
     */
    public function findLastFromTickerAndNotFound()
    {
        $serviceStatusInvest = new ServiceYahooFinance();
        $dataRequest = new DataYahooFinance('IBOX');
        $this->expectException(ServiceException::class);
        $responseData = $serviceStatusInvest->getLastValue($dataRequest);


    }
}