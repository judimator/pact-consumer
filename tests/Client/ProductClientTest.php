<?php

declare(strict_types=1);

namespace App\Tests\Client;

use App\Client\ProductClient;
use GuzzleHttp\Client;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Matcher\Matcher;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
use PHPUnit\Framework\TestCase;

class ProductClientTest extends TestCase
{
    public function testGetBySku(): void
    {
        $matcher = new Matcher();

        $request = new ConsumerRequest();
        $request
            ->setPath("/en/products")
            ->setQuery([
                'sku' => '12345',
            ])
            ->setMethod('GET');

        $response = new ProviderResponse();
        $response
            ->setStatus(200)
            ->setBody([
                'id' => $matcher->integer(),
                'name' => 'Test product 1',
                'sku' => '12345'
            ])
            ->addHeader('Content-Type', 'application/json');

        $config = new MockServerEnvConfig();
        $builder = new InteractionBuilder($config);
        $builder
            ->given('Product exists', [
                'name' => 'Test product 1',
                'sku' => '12345',
            ])
            ->uponReceiving('Get products by SKU')
            ->with($request)
            ->willRespondWith($response);

        $client = new Client([
            'base_uri' => $config->getBaseUri(),
        ]);
        $productClient = new ProductClient($client);
        $productClient->getBySku('12345');

        $verified = $builder->verify();

        self::assertTrue($verified);
    }
}
