<?php

namespace App\Message;

class StoreCurrencyExchangeDataMessage
{
    private array $currencyExchangeData;

    public function __construct(array $currencyExchangeData)
    {
        $this->currencyExchangeData = $currencyExchangeData;
    }

    public function getCurrencyExchangeData(): array
    {
        return $this->currencyExchangeData;
    }
}