<?php

declare(strict_types=1);

namespace LePhare\DoctrineJsonTranslation\Validator\Constraints;

use LePhare\DoctrineJsonTranslation\TranslatedField;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class TranslatedNotNullValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$value instanceof TranslatedField) {
            throw new UnexpectedValueException($value, TranslatedField::class);
        }

        if (!$constraint instanceof TranslatedNotNull) {
            throw new UnexpectedTypeException($constraint, TranslatedNotNull::class);
        }

        foreach ($value->all() as $value) {
            if ($value) {
                return;
            }
        }

        $this->context->buildViolation($constraint->message)->addViolation();
    }
}
