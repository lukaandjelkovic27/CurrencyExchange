<?php

namespace App\Controller;

use App\Form\GetMedianExchangeRateType;
use App\Message\StoreCurrencyExchangeDataMessage;
use App\Service\CurrencyExchangeService;
use App\Service\DateService;
use Carbon\Carbon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class CurrencyExchangeController extends AbstractController
{
    /**
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/median-exchange-rate', name: 'median-exchange-rate')]
    public function getEurToRsdMedianExchangeRate(Request $request, MessageBusInterface $bus, DateService $dateService, CurrencyExchangeService $exchangeService)
    {
        $form = $this->createForm(GetMedianExchangeRateType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $startDate = Carbon::parse($form->get('start_date')->getData());
            $endDate = Carbon::parse($form->get('end_date')->getData());

            $dateRange = $dateService->generateDateRange($startDate, $endDate);

            $medianExchangeRateData = $exchangeService->fetchExchangeRates($dateRange);

            $bus->dispatch(new StoreCurrencyExchangeDataMessage($medianExchangeRateData));

            return $this->render('currency-exchange/index.html.twig', [
                'form' => $form->createView(),
                'exchangeRateData' => $medianExchangeRateData,
            ]);
        }

        return $this->render('currency-exchange/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
