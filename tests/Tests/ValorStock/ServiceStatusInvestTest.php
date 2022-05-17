<?php

namespace Tests\Tests\ValorStock;

use PHPUnit\Framework\TestCase;
use StockValor\DataStatusInvest;
use StockValor\ServiceStatusInvest;

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

        $this->assertIsArray($responseData);
        $this->assertCount(1,$responseData);
        $this->assertObjectHasAttribute('prices',$responseData[0]);
    }
}