<?php

declare(strict_types=1);

namespace LePhare\DoctrineJsonTranslation;

class TranslatedField implements \Stringable, \JsonSerializable
{
    /**
     * @param array<string, string> $array
     */
    public function __construct(
        protected array $array,
        protected ?string $defaultLocale = \Locale::DEFAULT_LOCALE,
    ) {
        $this->array = $array;
        $this->defaultLocale = \Locale::getDefault();
    }

    public function __toString(): string
    {
        try {
            return $this->get();
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * @return array<string, string>
     */
    public function all(): array
    {
        return $this->array;
    }

    public function get(?string $locale = null): string
    {
        if (null === $locale && null !== $this->defaultLocale) {
            $locale = $this->defaultLocale;
        }

        if (null === $locale) {
            throw new \RuntimeException('No locale provided and no default locale set');
        }

        if (!\array_key_exists($locale, $this->array)) {
            throw new \RuntimeException('Locale '.$locale.' does not exist in this Field');
        }

        return $this->array[$locale];
    }

    public function has(?string $locale = null): bool
    {
        if (null === $locale && null !== $this->defaultLocale) {
            $locale = $this->defaultLocale;
        }

        if (null === $locale) {
            throw new \RuntimeException('No locale provided and no default locale set');
        }

        return \array_key_exists($locale, $this->array);
    }

    public function jsonSerialize(): string
    {
        return $this->__toString();
    }
}
