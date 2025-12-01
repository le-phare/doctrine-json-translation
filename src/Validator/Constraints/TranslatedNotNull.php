<?php

declare(strict_types=1);

namespace LePhare\DoctrineJsonTranslation\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class TranslatedNotNull extends Constraint
{
    public string $message = 'This value must be set for a least one locale.';

    public function validatedBy(): string
    {
        return static::class.'Validator';
    }

    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
