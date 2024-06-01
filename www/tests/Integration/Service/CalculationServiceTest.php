<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 16:07
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Tests\Integration\Service;

use App\Enum\PaymentProcessorType;
use App\Exception\ValidationException;
use App\Service\Calculator\CalculationService;
use App\Service\Calculator\DTO\CalculationDTO;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Class CalculationServiceTest
 *
 * @package App\Tests\Integration\Service
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class CalculationServiceTest extends KernelTestCase
{
    private CalculationService $calculationService;

    /**
     * @return void
     */
    public function setUp(): void
    {
        self::bootKernel();

        $this->calculationService = self::getContainer()->get(CalculationService::class);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testInitCalculation(): void
    {
        $calculation = $this->calculationService->initCalculation([
            'product'          => 1,
            'taxNumber'        => 'DE123456789',
            'couponCode'       => 'HAPPY13',
            'paymentProcessor' => mb_strtolower(PaymentProcessorType::PAYPAL->name),
        ]);

        $this->assertInstanceOf(CalculationDTO::class, $calculation);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testExceptionInitCalculation(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Validation error');

        // Product is invalid. Coupon is invalid. Tax number is invalid
        $this->calculationService->initCalculation([
            'product'          => 0,
            'taxNumber'        => 'DE12345678',
            'couponCode'       => 'HAPPY12',
            'paymentProcessor' => mb_strtolower(PaymentProcessorType::PAYPAL->name),
        ]);
    }

    /**
     * @return void
     * @throws ValidationException
     */
    public function testCalculatePrice(): void
    {
        $calculation = $this->calculationService->initCalculation([
            'product'          => 1,
            'taxNumber'        => 'DE123456789',
            'couponCode'       => 'HAPPY13',
            'paymentProcessor' => mb_strtolower(PaymentProcessorType::PAYPAL->name),
        ]);

        // Product 1. Coupon HAPPY13. Tax number DE123456789
        $price = $this->calculationService->calculatePrice($calculation);

        self::assertEquals(103.53, $price);

        // Product 1. Coupon SIO5. Tax number DE123456789
        $price = $this->calculationService->calculatePrice($calculation->setCoupon('SIO5'));

        self::assertEquals(113.05, $price);

        // Product 2. Coupon SIO5. Tax number DE123456789
        $price = $this->calculationService->calculatePrice($calculation->setProduct(2));

        self::assertEquals(22.61, $price);

        // Product 2. Coupon SIO5. Tax number FRer123456789
        $price = $this->calculationService->calculatePrice($calculation->setTaxNumber('FRer123456789'));

        self::assertEquals(22.8, $price);
    }
}
