<?php

declare(strict_types=1);

namespace LePhare\DoctrineJsonTranslation;

/**
 * @implements \ArrayAccess<string, mixed>
 */
class TranslatedField implements \ArrayAccess, \Stringable, \JsonSerializable
{
    /**
     * @param array<string, mixed> $array
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
            return $this->get() ?? '';
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return $this->array;
    }

    public function get(?string $locale = null): mixed
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

    public function set(mixed $offset, mixed $value): void
    {
        if (null === $offset) {
            throw new \BadFunctionCallException('offset should not be null');
        }

        $this->array[$offset] = $value;
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

    /**
     * @return array<string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->array;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->array[$offset]);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->array[$offset] ?? null;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->array[$offset]);
    }
}
