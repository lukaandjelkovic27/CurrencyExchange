<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class DateRange extends Constraint
{
    public string $message = 'The start date must be before the end date.';

    public function validatedBy()
    {
        return static::class.'Validator';
    }
}