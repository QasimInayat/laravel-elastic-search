<?php

namespace App\Services;

use Elastic\Elasticsearch\ClientBuilder;

class ProductSearchService
{
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([config('services.elastic.host')])
            ->build();
    }

    public function allProducts()
    {
        $params = [
            'index' => 'products_v2',
            'body'  => [
                'query' => [
                    'match_all' => new \stdClass()
                ]
            ]
        ];

        // dd($this->client->search($params));
        return $this->client->search($params);
    }

    public function search($keyword)
    {
        $params = [
            'index' => 'products_v2',
            'body'  => [
                'query' => [
                    'multi_match' => [
                        'query'  => $keyword,
                        'fields' => ['name', 'brand', 'category']
                    ]
                ]
            ]
        ];

        return $this->client->search($params);
    }
}
