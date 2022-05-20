<?php

namespace Tests\Tests\ValorStock;

use PHPUnit\Framework\TestCase;
use StockValor\DataStatusInvest;
use StockValor\DataYahooFinance;
use StockValor\Exceptions\ServiceException;
use StockValor\Impl\DataResponseAbstract;
use StockValor\ServiceIndexYahooFinance;
use StockValor\Value;
use DateTime;
class ServiceIndexYahooFinanceTest extends TestCase
{
    /**
     * @test
     */
    public function findDataFromTicker()
    {
        $serviceStatusInvest = new ServiceIndexYahooFinance();
        $dataRequest = new DataYahooFinance('BVSP');

        $responseData = $serviceStatusInvest->getDataFromUrl($dataRequest);

        $this->assertInstanceOf(DataResponseAbstract::class,$responseData);

    }

    /**
     * @test
     */
    public function findLastFromTicker()
    {
        $serviceStatusInvest = new ServiceIndexYahooFinance();
        $dataRequest = new DataYahooFinance('BVSP');

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
        $serviceStatusInvest = new ServiceIndexYahooFinance();
        $dataRequest = new DataYahooFinance('IBOX');
        $this->expectException(ServiceException::class);
        $responseData = $serviceStatusInvest->getLastValue($dataRequest);


    }
}