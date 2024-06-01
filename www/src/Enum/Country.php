<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 12:15
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Enum;

/**
 * @package App\Enum
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
enum Country: int
{
    case GERMANY = 1;
    case ITALY = 2;
    case FRANCE = 3;
    case GREECE = 4;

    /**
     * @return float
     */
    public function getTaxPercent(): float
    {
        return match ($this) {
            self::GERMANY => 19,
            self::ITALY   => 22,
            self::FRANCE  => 20,
            self::GREECE  => 24,
        };
    }

    /**
     * @return string
     */
    public function getTaxNumberRegex(): string
    {
        return match ($this) {
            self::GERMANY => '/^DE\d{9}$/',
            self::ITALY   => '/^IT\d{11}$/',
            self::FRANCE  => '/^FR[a-zA-Z]{2}\d{9}$/',
            self::GREECE  => '/^GR\d{9}$/',
        };
    }

    /**
     * @param string $taxNumber
     * @return Country|null
     */
    public static function tryFromTaxNumber(string $taxNumber): ?Country
    {
        foreach (self::cases() as $country) {
            if (preg_match($country->getTaxNumberRegex(), $taxNumber)) {
                return $country;
            }
        }

        return null;
    }
}
