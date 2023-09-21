<?php

declare(strict_types=1);

namespace App\Client;

use GuzzleHttp\Client;

class ProductClient
{
    public function __construct(private readonly Client $client)
    {
    }

    public function getBySku(string $sku): array
    {
        $response = $this->client->get("/en/products?sku=$sku");

        return json_decode($response->getBody()->getContents(), true);
    }
}
