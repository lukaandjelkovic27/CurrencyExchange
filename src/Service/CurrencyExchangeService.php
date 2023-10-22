<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class CurrencyExchangeService
{
    public function fetchExchangeRates(array $dateRange): array
    {
        $medianExchangeRateData = [];
        foreach ($dateRange as $date) {
            $route = $_ENV['CURRENCY_EXCHANGE_API'] . $date;
            $client = HttpClient::create();
            $response = $client->request('GET', $route, [
                'query' => [
                    'access_key' => $_ENV['CURRENCY_EXCHANGE_API_ACCESS_KEY'],
                    'base' => 'EUR',
                    'symbols' => 'RSD',
                ],
            ]);
            $medianExchangeRateData[] = $response->toArray();
        }
        return $medianExchangeRateData;
    }
}