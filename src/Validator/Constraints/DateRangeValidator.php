<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class DateRangeValidator extends ConstraintValidator
{

    public function validate(mixed $value, Constraint $constraint)
    {
        if (!$value instanceof \DateTimeInterface) {
            return;
        }

        $start_date = $this->context->getRoot()->get('start_date')->getData();

        if (!$start_date instanceof \DateTimeInterface) {
            return;
        }

        if ($start_date > $value) {
            $this->context->buildViolation($constraint->message)
                ->atPath('end_date')
                ->addViolation();
        }
    }
}