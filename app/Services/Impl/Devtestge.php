<?php

namespace App\Services\Impl;

use App\Services\DataFetchService;
use Facade\FlareClient\Http\Exceptions\BadResponseCode;
use GuzzleHttp\Client;

class Devtestge implements DataFetchService
{
    public function __construct(private Client $client)
    {
    }

    public function fetchCountries(): array
    {
        $req = $this->client->get('https://devtest.ge/countries', [
            'headers' => [
                'accept' => 'application/json'
            ]
        ]);
        if ($req->getStatusCode() !== 200) throw new \Exception('Failed to fetch countries!');
        $res = json_decode($req->getBody()->getContents(), true);
        return array_map(function ($item) {
            return [
                'name' => $item['name'],
                'code' => $item['code']
            ];
        }, $res);
    }

    public function fetchCountryStats(string $cc): array
    {
        $req = $this->client->post('https://devtest.ge/get-country-statistics', [
            'body' => json_encode(['code' => $cc]),
            'headers' => [
                'accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
        if ($req->getStatusCode() !== 200) throw new \Exception('Failed to fetch data');

        $res = json_decode($req->getBody()->getContents(), true);
        return [
            'confirmed' => $res['confirmed'],
            'recovered' => $res['recovered'],
            'critical' => $res['critical'],
            'deaths' => $res['deaths']
        ];
    }
}
