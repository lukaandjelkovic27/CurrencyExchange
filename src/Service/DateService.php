<?php

namespace App\Service;

use Carbon\Carbon;

class DateService
{
    public function generateDateRange(Carbon $startDate, Carbon $endDate): array
    {
        $dates = [];
        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->toDateString();
            $startDate->addDay();
        }
        return $dates;
    }
}