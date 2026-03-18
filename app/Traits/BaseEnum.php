<?php

namespace App\Traits;

trait BaseEnum
{
    public static function toArray()
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    public static function values()
    {
        return array_combine(
            array_map(fn($case) => $case->name, self::cases()),
            array_map(fn($case) => $case->value, self::cases())
        );
    }

    public static function labels()
    {
        return array_reduce(self::cases(), function ($carry, $case) {
            $carry[$case->value] = $case->label();
            return $carry;
        }, []);
    }

    public static function labelsExcept(array $excludedCases)
    {
        // normalize: support both enum cases and raw values
        $excludedValues = array_map(function ($item) {
            return $item instanceof self ? $item->value : $item;
        }, $excludedCases);

        return array_reduce(self::cases(), function ($carry, $case) use ($excludedValues) {
            if (!in_array($case->value, $excludedValues, true)) {
                $carry[$case->value] = $case->label();
            }
            return $carry;
        }, []);
    }

    public static function fromValue(string $value)
    {
        foreach (self::cases() as $case) {
            if ($case->value === $value)
                return $case;
        }
        return null;
    }

    public static function labelFrom(string $value)
    {
        return self::fromValue($value)?->label() ?? 'Unknown';
    }
}
