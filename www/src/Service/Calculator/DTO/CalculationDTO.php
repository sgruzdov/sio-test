<?php

/**
 * Created by PhpStorm
 * User: Sergey Gruzdov
 * Date: 01.06.24
 * Time: 12:04
 * Project: sio-test
 */

declare(strict_types=1);

namespace App\Service\Calculator\DTO;

use App\Enum\PaymentProcessorType;
use App\Validator\CouponConstraint;
use App\Validator\ProductConstraint;
use App\Validator\CalculationValidator;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class CalculationDTO
 *
 * @package App\Service\Calculator\DTO
 * @author  Sergey Gruzdov <s.gruzdov367@gmail.com>
 */
class CalculationDTO
{
    public const VALIDATION_GROUP_PURCHASE = 'Purchase';

    #[Assert\NotNull(message: 'error.field.required')]
    #[ProductConstraint]
    private ?int $product;

    #[Assert\NotNull(message: 'error.field.required')]
    #[Assert\Callback([CalculationValidator::class, 'validateTaxNumber'])]
    private ?string $taxNumber;

    #[CouponConstraint]
    private ?string $coupon;

    #[Assert\NotNull(message: 'error.field.required', groups: [CalculationDTO::VALIDATION_GROUP_PURCHASE])]
    #[Assert\NotEqualTo(
        PaymentProcessorType::INVALID,
        message: 'error.field.payment_processor.invalid',
        groups: [CalculationDTO::VALIDATION_GROUP_PURCHASE],
    )]
    private ?PaymentProcessorType $paymentProcessor;

    /**
     * Constructor CalculationDTO
     */
    private function __construct()
    {
    }

    /**
     * @return int|null
     */
    public function getProduct(): ?int
    {
        return $this->product;
    }

    /**
     * @param int|null $product
     * @return $this
     */
    public function setProduct(?int $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTaxNumber(): ?string
    {
        return $this->taxNumber;
    }

    /**
     * @param string|null $taxNumber
     * @return $this
     */
    public function setTaxNumber(?string $taxNumber): self
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCoupon(): ?string
    {
        return $this->coupon;
    }

    /**
     * @param string|null $coupon
     * @return $this
     */
    public function setCoupon(?string $coupon): self
    {
        $this->coupon = $coupon;

        return $this;
    }

    /**
     * @return PaymentProcessorType|null
     */
    public function getPaymentProcessor(): ?PaymentProcessorType
    {
        return $this->paymentProcessor;
    }

    /**
     * @param PaymentProcessorType|null $paymentProcessor
     * @return $this
     */
    public function setPaymentProcessor(?PaymentProcessorType $paymentProcessor): self
    {
        $this->paymentProcessor = $paymentProcessor;

        return $this;
    }

    /**
     * @param array $data
     * @return static
     */
    public static function from(array $data): static
    {
        $paymentProcessor = $data['paymentProcessor'] ?? null;

        if (!$paymentProcessor instanceof PaymentProcessorType) {
            $paymentProcessor = PaymentProcessorType::tryFromString(to_string($paymentProcessor));
        }

        return (new static())
            ->setProduct(try_to_int($data['product'] ?? null))
            ->setTaxNumber(try_to_string($data['taxNumber'] ?? null))
            ->setCoupon(try_to_string($data['couponCode'] ?? null))
            ->setPaymentProcessor($paymentProcessor);
    }
}
