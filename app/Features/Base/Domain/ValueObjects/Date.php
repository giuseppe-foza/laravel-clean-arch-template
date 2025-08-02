<?php
declare(strict_types=1);

namespace App\Features\Base\Domain\ValueObjects;

use DateMalformedStringException;
use DateTimeImmutable;
use DateTimeInterface;
use InvalidArgumentException;

final class Date
{
    private string $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function create(string|DateTimeInterface|null $value = null): self
    {
        if ($value instanceof DateTimeInterface) {
            return new self($value->format('Y-m-d H:i:s'));
        }

        if (is_string($value)) {
            $parsed = date_create($value);
            if (!$parsed) {
                throw new InvalidArgumentException("Formato de data inválido: {$value}");
            }

            return new self($parsed->format('Y-m-d H:i:s'));
        }

        if (is_null($value)) {
            return new self(new DateTimeImmutable()->format('Y-m-d H:i:s'));
        }

        throw new InvalidArgumentException('Valor de data não suportado.');
    }

    public function toValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    /**
     * @throws DateMalformedStringException
     */
    public function toDateTime(): DateTimeImmutable
    {
        return new DateTimeImmutable($this->value);
    }

    public static function now(): self
    {
        return new self(new DateTimeImmutable()->format('Y-m-d H:i:s'));
    }
}
