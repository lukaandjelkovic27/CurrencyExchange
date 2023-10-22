<?php

namespace App\MessageHandler;

use App\Entity\CurrencyExchange;
use App\Message\StoreCurrencyExchangeDataMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class StoreCurrencyExchangeDataMessageHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(StoreCurrencyExchangeDataMessage $message): void
    {
        $data = $message->getCurrencyExchangeData();
        $this->storeCurrencyExchangeData($data);
    }

    private function storeCurrencyExchangeData(array $data): void
    {
        $currencyExchange = new CurrencyExchange();
        $currencyExchange->setData($data);
        $this->entityManager->persist($currencyExchange);
        $this->entityManager->flush();
    }
}