<?php

namespace StockValor\Traits;

use GuzzleHttp\Client;

trait Request
{
    public function getRequestService(string $url):Client
    {
        return new Client(['base_uri' => $url]);
    }
}