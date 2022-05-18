<?php

namespace Tests\Tests\ValorStock;

use PHPUnit\Framework\TestCase;
use StockValor\DataStatusInvest;
use StockValor\Exceptions\ServiceException;
use StockValor\Impl\DataResponseAbstract;
use StockValor\ServiceIndexStatusInvest;
use StockValor\Value;
use DateTime;
class ServiceIndexStatusInvestTest extends TestCase
{
    /**
     * @test
     */
    public function findDataFromTicker()
    {
        $serviceStatusInvest = new ServiceIndexStatusInvest();
        $dataRequest = new DataStatusInvest('IBOV');

        $responseData = $serviceStatusInvest->getDataFromUrl($dataRequest);

        $this->assertInstanceOf(DataResponseAbstract::class,$responseData);

    }

    /**
     * @test
     */
    public function findLastFromTicker()
    {
        $serviceStatusInvest = new ServiceIndexStatusInvest();
        $dataRequest = new DataStatusInvest('IBOV');

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
        $serviceStatusInvest = new ServiceIndexStatusInvest();
        $dataRequest = new DataStatusInvest('IBOX');
        $this->expectException(ServiceException::class);
        $responseData = $serviceStatusInvest->getLastValue($dataRequest);


    }
}