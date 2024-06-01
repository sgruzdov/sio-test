<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 15:53
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Enum\Country;
use PHPUnit\Framework\TestCase;

/**
 * Class CountryTest
 *
 * @package App\Tests\Unit
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class CountryTest extends TestCase
{
    /**
     * @return void
     */
    public function testSuccessTaxNumber(): void
    {
        $germany = Country::tryFromTaxNumber('DE123456789');
        $italy = Country::tryFromTaxNumber('IT12345678901');
        $france = Country::tryFromTaxNumber('FRfr123456789');
        $greece = Country::tryFromTaxNumber('GR123456789');

        self::assertEquals(Country::GERMANY, $germany);
        self::assertEquals(Country::ITALY, $italy);
        self::assertEquals(Country::FRANCE, $france);
        self::assertEquals(Country::GREECE, $greece);
    }

    /**
     * @return void
     */
    public function testGermanyTaxNumber(): void
    {
        $germany1 = Country::tryFromTaxNumber('DE12345678');
        $germany2 = Country::tryFromTaxNumber('E12345678');
        $germany3 = Country::tryFromTaxNumber('DE1234d5678');

        self::assertNull($germany1);
        self::assertNull($germany2);
        self::assertNull($germany3);
    }

    /**
     * @return void
     */
    public function testItalyTaxNumber(): void
    {
        $italy1 = Country::tryFromTaxNumber('IT1234567890');
        $italy2 = Country::tryFromTaxNumber('T12345678901');
        $italy3 = Country::tryFromTaxNumber('IT1234r678901');

        self::assertNull($italy1);
        self::assertNull($italy2);
        self::assertNull($italy3);
    }

    /**
     * @return void
     */
    public function testFranceTaxNumber(): void
    {
        $france1 = Country::tryFromTaxNumber('FR00123456789');
        $france2 = Country::tryFromTaxNumber('Ffr123456789');
        $france3 = Country::tryFromTaxNumber('FRfr1234r5678');

        self::assertNull($france1);
        self::assertNull($france2);
        self::assertNull($france3);
    }

    /**
     * @return void
     */
    public function testGreeceTaxNumber(): void
    {
        $greece1 = Country::tryFromTaxNumber('GR12345678');
        $greece2 = Country::tryFromTaxNumber('G123456789');
        $greece3 = Country::tryFromTaxNumber('GR1234r6789');

        self::assertNull($greece1);
        self::assertNull($greece2);
        self::assertNull($greece3);
    }
}
