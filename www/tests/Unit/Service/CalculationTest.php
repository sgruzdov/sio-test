<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 15:56
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Tests\Unit\Service;

use App\Enum\PaymentProcessorType;
use App\Service\Calculator\DTO\CalculationDTO;

use PHPUnit\Framework\TestCase;

/**
 * Class CalculationTest
 *
 * @package App\Tests\Unit\Service
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class CalculationTest extends TestCase
{
    /**
     * @return void
     */
    public function testInitFullCalculation(): void
    {
        $calculation = CalculationDTO::from([
            'product'          => 1,
            'taxNumber'        => 'DE123456789',
            'couponCode'       => 'C10',
            'paymentProcessor' => mb_strtolower(PaymentProcessorType::PAYPAL->name),
        ]);

        self::assertEquals(1, $calculation->getProduct());
        self::assertEquals('DE123456789', $calculation->getTaxNumber());
        self::assertEquals('C10', $calculation->getCoupon());
        self::assertEquals(PaymentProcessorType::PAYPAL, $calculation->getPaymentProcessor());
    }

    /**
     * @return void
     */
    public function testInitCalculationWithEmptyData(): void
    {
        $calculation = CalculationDTO::from([]);

        self::assertEquals(0, $calculation->getProduct());
        self::assertEquals(null, $calculation->getTaxNumber());
        self::assertEquals(null, $calculation->getCoupon());
        self::assertEquals(null, $calculation->getPaymentProcessor());
    }

    /**
     * @return void
     */
    public function testInitCalculationWithInvalidData(): void
    {
        $calculation = CalculationDTO::from([
            'product'          => '3d322d2',
            'taxNumber'        => 232424,
            'couponCode'       => 10,
            'paymentProcessor' => 777,
        ]);

        self::assertEquals(33222, $calculation->getProduct());
        self::assertEquals('232424', $calculation->getTaxNumber());
        self::assertEquals('10', $calculation->getCoupon());
        self::assertEquals(PaymentProcessorType::INVALID, $calculation->getPaymentProcessor());

        $calculation = CalculationDTO::from([
            'product'          => '1',
            'taxNumber'        => 'DE123456789',
            'paymentProcessor' => 'undefined',
        ]);

        self::assertEquals(1, $calculation->getProduct());
        self::assertEquals(PaymentProcessorType::INVALID, $calculation->getPaymentProcessor());
    }
}
