<?php

namespace StockValor\Traits;

use GuzzleHttp\Client;

trait Request
{
    public function getRandomIp():string
    {
        $endRange = rand(2,254);
        $middleRange = rand(0,254);
        $ip = '10.5.'.$middleRange.'.'.$endRange;
        return $ip;

    }
    public function getRequestService(string $url = ''):Client
    {
        return new Client(['base_uri' => $url,
            'headers' => [
                'Content-Type' => 'application/json',
                'X-Forwarded-For' => $this->getRandomIp()
            ]
        ]);
    }
}