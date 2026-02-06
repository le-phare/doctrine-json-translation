<?php

declare(strict_types=1);

namespace LePhare\DoctrineJsonTranslation\DBAL;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonbType;
use LePhare\DoctrineJsonTranslation\TranslatedField;

class TranslatedType extends JsonbType
{
    public function convertToPHPValue(mixed $value, AbstractPlatform $platform): ?TranslatedField
    {
        $array = parent::convertToPHPValue($value, $platform);

        if (!\is_array($array)) {
            return null;
        }

        return new TranslatedField($array);
    }

    public function convertToDatabaseValue(mixed $value, AbstractPlatform $platform): ?string
    {
        if (null === $value) {
            return null;
        }

        $result = json_encode($value);

        if (false === $result) {
            return null;
        }

        return $result;
    }
}
