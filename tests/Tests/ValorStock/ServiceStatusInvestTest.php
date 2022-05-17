<?php

namespace Tests\Tests\ValorStock;

use PHPUnit\Framework\TestCase;
use StockValor\DataStatusInvest;
use StockValor\Impl\DataResponseAbstract;
use StockValor\Impl\DataStatusInvestAbstract;
use StockValor\ServiceStatusInvest;
use StockValor\Value;
use DateTime;
class ServiceStatusInvestTest extends TestCase
{
    /**
     * @test
     */
    public function findDataFromTicker()
    {
        $serviceStatusInvest = new ServiceStatusInvest();
        $dataRequest = new DataStatusInvest('BRFS3');

        $responseData = $serviceStatusInvest->getDataFromUrl($dataRequest);

        $this->assertInstanceOf(DataResponseAbstract::class,$responseData);

    }

    /**
     * @test
     */
    public function findLastFromTicker()
    {
        $serviceStatusInvest = new ServiceStatusInvest();
        $dataRequest = new DataStatusInvest('BRFS3');

        $responseData = $serviceStatusInvest->getLastValue($dataRequest);
        $this->assertInstanceOf(Value::class,$responseData);
        $this->assertIsFloat($responseData->getPrice());
        $this->assertInstanceOf(DateTime::class,$responseData->getDate());

    }
}