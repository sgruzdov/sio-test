<?php

if (!function_exists('to_int')) {
    /**
     * @param string|int|float|bool|null $value
     * @return int
     */
    function to_int(string|int|float|bool|null $value): int
    {
        if (\is_string($value)) {
            $value = preg_replace(['~(?![\d.,-]).~', '~,~'], ['', '.'], $value);
        }

        return (int) $value;
    }
}

if (!function_exists('try_to_int')) {
    /**
     * @param string|int|float|bool|null $value
     * @return int|null
     */
    function try_to_int(string|int|float|bool|null $value): ?int
    {
        return ($value === null || $value === '') ? null : to_int($value);
    }
}

if (!function_exists('to_float')) {
    /**
     * @param mixed $value
     * @return float
     */
    function to_float(mixed $value): float
    {
        if (\is_string($value)) {
            $value = preg_replace(['~(?![\d.,-]).~', '~,~'], ['', '.'], $value);
        }

        return (float) $value;
    }
}

if (!function_exists('try_to_float')) {
    /**
     * @param mixed $value
     * @return float|null
     */
    function try_to_float(mixed $value): ?float
    {
        return ($value === null || $value === '') ? null : to_float($value);
    }
}

if (!function_exists('to_bool')) {
    /**
     * @param mixed $value
     * @return bool
     */
    function to_bool(mixed $value): bool
    {
        $type = \gettype($value);

        if (!\in_array($type, ['boolean', 'string', 'integer', 'NULL'], true)) {
            throw new \LogicException(sprintf('Expected: boolean, string, integer or NULL. Received: %s', $type));
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }
}

if (!function_exists('to_string')) {
    /**
     * @param string|int|float|null $value
     * @return string
     */
    function to_string(mixed $value): string
    {
        $type = \gettype($value);

        if (!\in_array($type, ['string', 'double', 'integer', 'NULL'], true)) {
            throw new \LogicException(sprintf('Expected: string, double, integer or NULL. Received: %s', $type));
        }

        return strip_tags(str_replace(["\n", "\r"], ' ', trim((string) $value)));
    }
}

if (!function_exists('try_to_string')) {
    /**
     * @param mixed $value
     * @return array|null
     */
    function try_to_string(mixed $value): ?string
    {
        return ($value === null || $value === '') ? null : to_string($value);
    }
}

if (!function_exists('explode_string_to_nested_array')) {
    /**
     * @param string $delimiter
     * @param string $key
     * @param mixed  $value
     * @return array
     */
    function explode_string_to_nested_array(string $delimiter, string $key, mixed $value): array
    {
        $keys = explode($delimiter, $key);

        while ($key = array_pop($keys)) {
            $value = [$key => $value];
        }

        return $value;
    }
}